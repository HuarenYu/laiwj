<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Intervention\Image\ImageManagerStatic as Image;
use Qiniu\Auth as QiniuAuth;
use Auth;

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

    public function uploadToken()
    {
        if (!Auth::check()) {
            return response('permission denied', 401);
        }
        $accessKey = 'mm7DgMox5dQGud1ytowVGiTU_PEk-8J_kpB15o7L';
        $secretKey = 'DWED4vfydjGzjAE6iCwpmCL5evEoYzuglYYj-INB';
        $auth = new QiniuAuth($accessKey, $secretKey);
        // 空间名  http://developer.qiniu.com/docs/v6/api/overview/concepts.html#bucket
        $bucket = 'lwjb';
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        return response()->json(['uptoken' => $token]);
    }

}
