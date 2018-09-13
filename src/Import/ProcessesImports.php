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

use Excel;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Deadan\Support\Import\Events\ImportCompleted;
use Deadan\Support\Import\Events\ImportStarted;

trait ProcessesImports
{
    /**
     * @var \Deadan\Support\Import\ImportQueue
     */
    public $importQueue;
    
    /**
     * @var array
     */
    public $failed = [];
    
    /**
     * @param \Deadan\Support\Import\ImportQueue $importQueue
     *
     * @return \Deadan\Support\Import\ProcessesImports
     */
    public function setImportQueue(ImportQueue $importQueue)
    {
        $this->importQueue = $importQueue;
        
        return $this;
    }
    
    /**
     * Execute the job.
     *
     * @return mixed
     * @throws \Throwable
     */
    public function handle()
    {
        if ($this->importQueue->trashed()) {
            $this->delete();
            return false;
        }
        
        \Auth::loginUsingId($this->importQueue->created_by);
        
        $file = $this->importQueue->original_file_path;
        
        event(new ImportStarted($this->importQueue));
        
        // only loads the first sheet
        $path = $this->prepareFilePath($this->importQueue);
        $excel = Excel::load($path);
        
        $this->importQueue->update([
            'total_entries' => $excel->getTotalRowsOfFile() - 1,//minus one because of heading row
            'status'        => ImportQueue::STATUS_PROCESSING,
            'failed'        => 0,
            'successful'    => 0,
        ]);
        
        $excel->each(function ($sheet) {
            $sheet->each(function ($row) {
                $this->persist($row->toArray());
            });
        });
        
        //save the failed imports log
        $failedItemsPath = $this->saveFailedToFile();
        
        $this->importQueue->update([
            'status'              => ImportQueue::STATUS_COMPLETED,
            'failed_entries_path' => $failedItemsPath,
        ]);
        
        event(new ImportCompleted($this->importQueue));
        
        return $this->importQueue;
    }
    
    /**
     * @param \Deadan\Support\Import\ImportQueue $importQueue
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function prepareFilePath(ImportQueue $importQueue)
    {
        $path = $importQueue->original_file_path;
        
        //if the file is stored in the cloud, we have to download it and store locally
        if (config('filesystems.default') != 'local') {
            $fileDriver = config('filesystems.default');
            _copy($fileDriver, 'local', $importQueue->original_file_path);
        }
        
        //laravel excel expects a full path
        return storage_path('app/' . $path);
    }
    
    /**
     * @param array $row
     *
     * @throws \Throwable
     */
    public function persist(array $row)
    {
        $validationResult = $this->validateImportRow($row);
        
        \Log::info("validation result=>" . json_encode($validationResult));
        
        if (is_bool($validationResult) && true === $validationResult) {
            $this->importQueue->increment('successful');
            $this->save($row);
        } else {
            $validationResult = array_wrap($validationResult);
            $this->logFailedRow($row, $validationResult);
            $this->importQueue->increment('failed');
        }
    }
    
    /**
     * @param $row
     * @param $errors
     */
    public function logFailedRow($row, $errors)
    {
        $this->failed[] = array_merge($row, ['errors' => implode("\n", array_flatten($errors))]);
    }
    
    /**
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function saveFailedToFile()
    {
        $input = $this->failed;
        $filename = $this->importQueue->uuid . "-failed";
        
        $writer = Excel::create($filename);
        
        $writer->sheet('Sheet1', function (LaravelExcelWorksheet $sheet) use ($input) {
            
            $sheet->fromArray($input, null, 'A1', true);
            
        })->save("xlsx", storage_path("app/imports/"), true);
        
        //if the driver is not local, we have to copy the file from local to that driver
        if (config('filesystems.default') != 'local') {
            $fileDriver = config('filesystems.default');
            $filePath = 'imports/' . $filename . ".xlsx";
            _copy('local', $fileDriver, $filePath);
        }
        
        return 'imports/' . $filename . ".xlsx";
    }
}