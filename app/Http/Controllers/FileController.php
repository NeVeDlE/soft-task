<?php

namespace App\Http\Controllers;

use App\Encryption\AesEncryption;
use App\Helpers\FileMetadataHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    //just returns the file upload view
    public function index()
    {
        return view('file-upload');
    }


    //simply returns full data for the uploaded file
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileExtension = $file->getClientOriginalExtension();

        $path = $file->storeAs('uploads', $fileName);

        return view('file-details', compact('fileName', 'fileSize', 'fileExtension', 'path'));
    }

    public function encrypt(Request $request)
    {
        //validate the data
        $request->validate([
            'file_path' => 'required',
            'key' => 'required',
            'file_name' => 'required',
        ]);
         // get the stored file
        $filePath = storage_path('app/' . $request->file_path);
        $key = $request->key;
        $fileName = $request->file_name;

        //get contents of the file
        $data = file_get_contents($filePath);

        $aes = AesEncryption::getInstance($key);
        $encryptedData = $aes->encrypt($data);
        //get the extension to append to meta data
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        $encryptedDataWithMetadata = FileMetadataHelper::addMetadata($encryptedData, ['extension' => $fileExtension]);

        return response()->streamDownload(function() use ($encryptedDataWithMetadata) {
            echo $encryptedDataWithMetadata;
        }, $fileName . '.enc');
    }

    public function decrypt(Request $request)
    {
        $request->validate([
            'file_path' => 'required',
            'key' => 'required',
            'file_name' => 'required',
        ]);

        $filePath = storage_path('app/' . $request->file_path);
        $key = $request->key;
        $fileName = $request->file_name;

        $data = file_get_contents($filePath);

        [$metadata, $encryptedData] = FileMetadataHelper::extractMetadata($data);

        $aes = AesEncryption::getInstance($key);
        $decryptedData = $aes->decrypt($encryptedData);

        return response()->streamDownload(function() use ($decryptedData) {
            echo $decryptedData;
        }, $fileName . '.' . $metadata['extension']);
    }
}
