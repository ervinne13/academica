<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use function env;
use function public_path;
use function response;

class FilesController extends Controller {

    public function upload() {
        $file = Input::file('file');

        $generatedFilename = "";

        if ($file) {
            $extension         = $this->getFileExtension($file->getClientOriginalName());
            $generatedFilename = $this->generateFileName($extension);
            $file->move(public_path() . '/uploads/', $generatedFilename);
        } else {
            return response("File invalid or no file uploaded", 500);
        }

        return $generatedFilename;
    }

    private function getFileExtension($fileName) {
        $splittedFileName = explode(".", $fileName);
        return $splittedFileName[count($splittedFileName) - 1];
    }

    private function generateFileName($extension) {
        $fileName = date('Y_m_d_His');
        return "{$fileName}.{$extension}";
    }

}
