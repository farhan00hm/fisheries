<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hilsa;
use App\Service\ExcelDataStoreService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HilsaController extends Controller
{
    public function index(){
        $hilsas = hilsa::paginate(20);
        return view('admin.hilsa')->with("hilsas",$hilsas);
    }

    public function store(Request $request){

        $this->filevaidate();

        $files =   $request->file('hilsa_files');
        $existing_files = array();
        $uploaded_files = array();
        $excelDataStore ="";
        foreach ($files as $file){
//            dd($file);
            $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            try{
                $hilsa = new Hilsa();
                $hilsa->file_name = $fileName;

                global $uploaded_files,$excelDataStore;
                $excelDataStore = new ExcelDataStoreService($request);
                $excelDataStore->storeCellDataIntoDatabase($file,$fileName);
                $hilsa->save();
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
        return redirect('/admin/hilsa');
//        return redirect(route('admin.dashboard'));

    }

    public function filevaidate()
    {
        return request()->validate([
            'hilsa_files' => 'required',
            'hilsa_files.*' => 'mimes:xlsx,xls'
        ]);
    }
}
