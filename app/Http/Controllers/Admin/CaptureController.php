<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Capture;
use App\Service\ExcelDataStoreService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaptureController extends Controller
{
    public function index(){
        $captures = Capture::paginate(20);
        return view('admin.capture')->with("captures",$captures);
    }

    public function store(Request $request){

        $this->filevaidate();

        $files =   $request->file('capture_files');
        $existing_files = array();
        $uploaded_files = array();
        $excelDataStore ="";
        foreach ($files as $file){
//            dd($file);
            $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            try{
                $capture = new Capture();
                $capture->file_name = $fileName;

                global $uploaded_files,$excelDataStore;
                $excelDataStore = new ExcelDataStoreService($request);
                $excelDataStore->storeCellDataIntoDatabase($file,$fileName);
                $capture->save();
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    array_push($existing_files,$fileName);
                    Log::info($fileName. " Already exist");
                }
            }

        }

//        $uploaded_files = $excelDataStore->getUploadedFiles();
//        TODO need to pass success and failure file
        return redirect('/admin/capture');
//        return redirect(route('admin.dashboard'));

    }

    public function filevaidate()
    {
        return request()->validate([
            'capture_files' => 'required',
            'capture_files.*' => 'mimes:xlsx,xls'
        ]);
    }
}
