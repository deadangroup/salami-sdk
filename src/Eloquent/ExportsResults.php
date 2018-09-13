<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Eloquent;

use Excel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ExportsResults
{
    public $supportedFormats = ['xls', 'xlsx', 'csv', /*'pdf'*/];
    public $defaultFormat = 'xlsx';
    
    /**
     * @param $collection
     *
     * @return mixed
     */
    public function export(Collection $collection, $name)
    {
        $format = request()->get('download');
        $format = in_array($format, $this->supportedFormats) ? $format : $this->defaultFormat;
        $filename = time() . "-" . $name;
        $collection = $this->prepareCollection($collection);
        
        $excel = Excel::create($filename, function ($excel) use ($collection, $filename) {
            
            $excel->sheet('Sheet 1', function ($sheet) use ($collection) {
                $sheet->fromArray($collection->toArray());
            });
        });
        
        event(new EloquentResultsExportedEvent($filename, $format));
        
        return $excel->download($format);
    }
    
    /**
     * Process the collection and hide or show fields as required.
     *
     * @param Collection $collection
     *
     * @return Collection
     */
    private function prepareCollection(Collection $collection)
    {
        $collection->transform(function (Model $item, $key) {
            if ($item instanceof IsExportable) {
                return $item->only($item->exportFields());
            }
            
            return $item->toArray();
        });
        
        return $collection;
    }
    
    public function requestsDownload()
    {
        return request()->get('download') ? true : false;
    }
}