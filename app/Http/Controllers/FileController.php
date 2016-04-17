<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Intervention\Image\ImageManagerStatic as Image;

class FileController extends Controller
{

    public function image(Request $request)
    {
        $file = $request->file('image');
        $fileSha1 = sha1_file($file->getPathname());
        $image = Image::make($file);
        $image->fit(800, 600, function ($constraint) {
            $constraint->aspectRatio();
        })
        ->save(public_path().'/media/images/'.$fileSha1.'.jpg');
        return response()
            ->json(['image' => $fileSha1.'.jpg'])
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function upload()
    {
        return view('test');
    }

}
