<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Import;

use Auth;
use Illuminate\Http\Request;
use Session;
use Storage;

trait SavesImports
{
    /**
     * @var array
     */
    public $importRules = [
        'file' => 'required|mimes:csv,xlsx,xls',
    ];

    /**
     * Returns a list of previous imports
     *
     * @return mixed
     */
    public function getPreviousImports()
    {
        $result = ImportQueue::byUser(Auth::id())->byType($this->importType)->recent()->get();
        $result->transform(function ($item, $key) {
            $out = $item->toArray();

            if (is_numeric($item->total_entries) && $item->total_entries > 0) {
                $progress = (($item->successful + $item->failed) / $item->total_entries) * 100;
            } else {
                $progress = 0;
            }

            //useful if we want to hide the internal url of the file
            $out['url'] = route($this->importType . ".import.download",
                [$item->uuid]);

            return array_merge($out, [
                'progress' => $progress,
                'status'   => ucfirst($item->status),
            ]);
        });

        return response()->json([
            'success' => true,
            'items'   => $result,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeImportFile(Request $request)
    {
        $this->validate($request, $this->getImportRules());

        $file = $request->file;

        $path = $file->store('imports');

        $importQueue = ImportQueue::create([
            'type'               => $this->importType,
            'status'             => ImportQueue::STATUS_PENDING,
            'created_by'         => Auth::id(),
            'original_file_path' => $path,
            'original_file_name' => $file->getClientOriginalName(),
        ]);

        //start a job to process the file
        $job = app($this->importJob)->setImportQueue($importQueue);

        $this->dispatch($job);

        Session::flash('success', 'Your import has been queued. You will be notified when it\'s complete.');

        return redirect()->route($this->importType . '.import');
    }

    /**
     * @return array
     */
    public function getImportRules(): array
    {
        $this->importRules['file'] .= '|max:' . config('general.imports.max_size') * 1024;
        return $this->importRules;
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteImport($id)
    {
        $import = ImportQueue::byUser(Auth::id())->byType($this->importType)->where('uuid', $id)->firstOrFail();

        if (str_contains($import->status, ImportQueue::STATUS_PROCESSING)) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    "$id has started being processed and cannot be cancelled.",
                ],
            ], 400);

        } else {

            //first delete import file
            Storage::disk('local')->delete($import->original_file_path);
            Storage::delete($import->original_file_path);

            //then delete failed imports file
            Storage::disk('local')->delete($import->failed_entries_path);
            Storage::delete($import->failed_entries_path);

            //then the model itself
            $import->delete();

            return response()->json([
                'success' => true,
            ]);
        }
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadImport($id)
    {
        $import = ImportQueue::byUser(Auth::id())->byType($this->importType)->where('uuid', $id)->firstOrFail();
        $type = request('type');

        if ($type == 'failed') {
            $file = $import->failed_entries_path;
        } else {
            $file = $import->original_file_path;
        }

        //s3 requires special treatment since files are stored in private buckets
        if (config('filesystems.default') == 's3') {
            return force_s3_download($file, $file);
        }

        //the following has only been tested for local
        return response()->download(Storage::path($file));
    }
}