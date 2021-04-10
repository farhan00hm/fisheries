<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaptureController extends Controller
{
    public function index(){
        return view('admin.capture');
    }

    public function store(Request $request){
        $this->filevaidate();
        $files =   $request->file('selected_files');
        $existing_files = array();
        $uploaded_files = array();
        foreach ($files as $file){
            $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            try{

            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    array_push($existing_files,$fileName);
                    Log::info($fileName. " Already exist");
                }
            }

        }

    }

    public function filevaidate()
    {
        return request()->validate([
            'capture_files' => 'required',
            'capture_files.*' => 'mimes:xlsx,xls'
        ]);
    }
}
