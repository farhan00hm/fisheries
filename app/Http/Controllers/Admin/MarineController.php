<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marine;
use App\Service\ExcelDataStoreService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarineController extends Controller
{
    public function index()
    {
        $marines = Marine::paginate(20);
        return view('admin.marine')->with("marines", $marines);
    }

    public function store(Request $request){

        $this->filevalidate();

        $files =   $request->file('marine_files');
        $existing_files = array();
        $uploaded_files = array();
        $excelDataStore ="";
        foreach ($files as $file){
            $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            try{
                $marine = new marine();
                $marine->file_name = $fileName;

                global $uploaded_files,$excelDataStore;
                $excelDataStore = new ExcelDataStoreService($request);
                $excelDataStore->storeCellDataIntoDatabase($file,$fileName);
                $marine->save();
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    array_push($existing_files,$fileName);
                    Log::info($fileName. " Already exist");
                }
            }

        }

//        TODO need to pass success and failure file
        return redirect('/admin/marine');

    }

    public function filevalidate()
    {
        return request()->validate([
            'marine_files' => 'required',
            'marine_files.*' => 'mimes:xlsx,xls'
        ]);
    }
}
