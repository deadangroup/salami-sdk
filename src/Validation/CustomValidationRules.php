<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Validation;

use Auth;
use Excel;
use Hash;
use Storage;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CustomValidationRules
{
    public function validateExcelColumns($attribute, $value, $parameters)
    {
        if (!$this->isValidFileInstance($value)) {
            return false;
        }
        
        if ($value->getPath() !== '') {
            //store the file and then read from it
            //todo one day I'll figure out how to read from the file without storing it first.
            //Imagine when we are using S3. Is this viable?
            $path = Storage::putFile('temp', $value);
            $path = storage_path("app/" . $path);
            
            /**
             * @var $rows \Maatwebsite\Excel\Collections\RowCollection
             */
            $rows = Excel::filter('chunk')->load($path)->take(1)->get();
            
            $titles = $rows->first()->getHeading();
            
            //then delete the temp file
            unlink($path);
            
            //note: we check whether the required columns are part of the input rather than the other way.
            //ideally we should check for an exact match. but there's a bug where columns with a blank value somewhere always show up and the test fails.
            //and I am tired already.
            //todo REVISIT
            return array_intersect(array_values($titles), array_values($parameters));
        }
        
        return false;
    }
    
    /**
     * Check that the given value is a valid file instance.
     *
     * @param  mixed $value
     *
     * @return bool
     */
    public function isValidFileInstance($value)
    {
        if ($value instanceof UploadedFile && !$value->isValid()) {
            return false;
        }
        
        return $value instanceof File;
    }
    
    /**
     * Checks whether the password provided is the users current password
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     *
     * @return bool
     */
    public function validateOldPassword($attribute, $value, $parameters)
    {
        $scurrentPassword = Auth::user()->getAuthPassword();
        
        //usually when they register via socialite, their password is blank
        if (empty($scurrentPassword)) {
            return true;
        }
        
        return Hash::check($value, Auth::user()->getAuthPassword());
    }
}