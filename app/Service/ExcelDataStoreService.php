<?php


namespace App\Service;


use App\Imports\ExcelImporter;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class ExcelDataStoreService
{
    public  $request;
    private $uploaded_files = array();

    public function __construct($request) {
        $this->request = $request;
    }

    public function storeCellDataIntoDatabase($file,$fileName){

        $import = new ExcelImporter();
        Excel::import($import,$file);
        $rows = $import->rows->toArray();
        $attributeName = [];
        $tableHeads = [];
        Log::info("Rows is: ",$rows);
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
                array_push($this->uploaded_files,$fileName);

            }
        }
    }

    public function createTable($tableName, $tableHeads = [])
    {

        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) use ($tableHeads, $tableName) {
                $table->increments('id');
                if (count($tableHeads) > 0) {
                    foreach ($tableHeads as $tableHead) {
                        if($tableHead['type'] == "double"){
                            $table->{$tableHead['type']}($tableHead['name'])->nullable();
                        }else{
                            $table->{$tableHead['type']}($tableHead['name'])->nullable();
                        }
                    }
                }
//                $table->timestamps();
            });
//            return response()->json(['message' => 'Given table has been successfully creted']);
//            Log::info("Table Name is: ".$tableName);
            return true;
        }
//        return response()->json(['message' => 'Given table is already Exists.', 400]);
        return false;
    }

    public function getUploadedFiles(){

//        Log::info("Upload Files: ".$this->uploaded_files);
        return $this->uploaded_files;
    }
}
