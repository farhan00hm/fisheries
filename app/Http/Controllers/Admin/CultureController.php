<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Culture;
use App\Service\ExcelDataStoreService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CultureController extends Controller
{
    public function index()
    {
        $cultures = Culture::paginate(20);
        return view('admin.culture')->with("cultures", $cultures);
    }

    public function store(Request $request){

        $this->filevalidate();

        $files =   $request->file('culture_files');
        $existing_files = array();
        $uploaded_files = array();
        $excelDataStore ="";
        foreach ($files as $file){
            $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            try{
                $culture = new Culture();
                $culture->file_name = $fileName;

                global $uploaded_files,$excelDataStore;
                $excelDataStore = new ExcelDataStoreService($request);
                $excelDataStore->storeCellDataIntoDatabase($file,$fileName);
                $culture->save();
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    array_push($existing_files,$fileName);
                    Log::info($fileName. " Already exist");
                }
            }

        }

//        TODO need to pass success and failure file
        return redirect('/admin/culture');

    }

    public function filevalidate()
    {
        return request()->validate([
            'culture_files' => 'required',
            'culture_files.*' => 'mimes:xlsx,xls'
        ]);
    }
}
