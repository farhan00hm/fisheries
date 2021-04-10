<?php


namespace App\Service;


use App\Imports\ExcelImporter;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelDataStoreService
{
    public  $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function storeCellDataIntoDatabase($file,$fileName){
        $import = new ExcelImporter();
        Excel::import($import,$file);
        $rows = $import->rows->toArray();
        $attributeName = [];
        $tableHeads = [];
        foreach ($rows as $key => $row) {

            if ($key == 0) {
                for ($i = 0; $i < sizeof($row); $i++) {
                    array_push($attributeName, $row[$i]);
                }
            }

            if ($key == 1) {
                for ($i = 0; $i < sizeof($row); $i++) {

                    array_push($tableHeads, ['name' => $attributeName[$i], 'type' => is_numeric($row[$i]) ? 'double' : 'string']);
                }
                if(!$this->createTable($fileName,$tableHeads)){
                    dd("Table already Exist for given file name");
                }

            }

            if($key>0){
//                    excel data store in tableData array
                $cellData = [];
                for ($i = 0 ; $i<sizeof($row); $i++){
                    $cellData[$attributeName[$i]] = $row[$i];
                }
                DB::table($fileName)->insert($cellData);

            }
        }
    }

}
