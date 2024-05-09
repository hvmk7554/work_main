<?php

namespace App\Traits;

use App\Exports\ExportObject;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;

trait ExcelSupportTrait{


    public function getDataImport(ToCollection $import, UploadedFile $file): ToCollection
    {
        Excel::import($import,$file);
        return $import;
    }

    /**
     * @param array|FromCollection $object
     * @param string $filename
     * @return bool
     */
    public function storeFile(array|FromCollection $object,string $filename): bool
    {
        if ($object instanceof FromCollection){
            return Excel::store($object,$filename);
        }

        return Excel::store(ExportObject::make($object),$filename);

    }
}
