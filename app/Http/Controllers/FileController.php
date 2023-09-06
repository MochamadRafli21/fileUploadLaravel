<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file:xlsx,xlsm,xls,pdf|max:4096'
        ]);

        if ($validator->fails()) {
            $error = array('message' => 'error','status'=> 400 );
            return $error;
        };
        $uploadFolder = 'files';
        $file = $request->file('file');
        $file_uploaded_path = $file->move($uploadFolder, date('Yhis').$file->getClientOriginalName());
        $uploadedFileResponse = array(
           "file_name" => basename($file_uploaded_path),
           "file_url" => url($file_uploaded_path),
           "mime" => $file->getClientMimeType()
        );
        return $uploadedFileResponse;
    }
}
