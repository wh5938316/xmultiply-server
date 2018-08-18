<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\FileModel;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    public function upload(Request $request) {
        // $fileName = $_FILES["file"]["name"] . '--' . str_random(10);

        $fileName = str_random(10) . $this->getExtension($_FILES["file"]["name"]);
        $path = "upload/" . $fileName;
        move_uploaded_file($_FILES["file"]["tmp_name"],
        public_path($path));
        $fileModel = FileModel::create([
            'name' => $_FILES["file"]["name"],
            'url' => $path,
            'size' => $_FILES["file"]["size"]
        ]);

        return [
            'errors' => false,
            'data' => [
                'name' => $fileModel->name,
                'url' => $fileModel->url,
                'size' => $fileModel->size
            ]
        ];
    }

    // protected function getName($file) { 
    //     return substr(strrchr($file, '.'), 1); 
    // }

    protected function getExtension($file) { 
        return substr(strrchr($file, '.'), 0); 
    }
}
