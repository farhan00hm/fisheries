<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\shrimp;
use App\Service\ExcelDataStoreService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShrimpController extends Controller
{
    public function index()
    {
        $shrimps = shrimp::paginate(20);
        return view('admin.shrimp')->with("shrimps", $shrimps);
    }

    public function store(Request $request){

        $this->filevalidate();

        $files =   $request->file('shrimp_files');
        $existing_files = array();
        $uploaded_files = array();
        $excelDataStore ="";
        foreach ($files as $file){
            $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            try{
                $shrimp = new shrimp();
                $shrimp->file_name = $fileName;

                global $uploaded_files,$excelDataStore;
                $excelDataStore = new ExcelDataStoreService($request);
                $excelDataStore->storeCellDataIntoDatabase($file,$fileName);
                $shrimp->save();
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    array_push($existing_files,$fileName);
                    Log::info($fileName. " Already exist");
                }
            }

        }

//        TODO need to pass success and failure file
        return redirect('/admin/shrimp');

    }

    public function filevalidate()
    {
        return request()->validate([
            'shrimp_files' => 'required',
            'shrimp_files.*' => 'mimes:xlsx,xls'
        ]);
    }
}
