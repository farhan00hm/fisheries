<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Others;
use App\Service\ExcelDataStoreService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OthersController extends Controller
{
    public function index(){
        $others = Others::paginate(20);
        return view('admin.others')->with("others",$others);
    }

    public function store(Request $request){

        $this->filevaidate();

        $files =   $request->file('other_files');
        $existing_files = array();
        $uploaded_files = array();
        $excelDataStore ="";
        foreach ($files as $file){
            $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            try{
                $other = new Others();
                $other->file_name = $fileName;
                $other->save();

                global $uploaded_files,$excelDataStore;
                $excelDataStore = new ExcelDataStoreService($request);
                $excelDataStore->storeCellDataIntoDatabase($file,$fileName);
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    array_push($existing_files,$fileName);
                    Log::info($fileName. " Already exist");
                }
            }

        }

//        TODO need to pass success and failure file
        return redirect('/admin/others');

    }

    public function filevaidate()
    {
        return request()->validate([
            'other_files' => 'required',
            'other_files.*' => 'mimes:xlsx,xls'
        ]);
    }
}
