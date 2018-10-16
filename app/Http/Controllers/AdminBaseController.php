<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Storage;

class AdminBaseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    protected function uploadSingleFile ($file)
    {
        $folderName = 'public/'.date('Ymd');
        if (! Storage::disk('local')->exists($folderName)) {
            Storage::makeDirectory($folderName);
        }

        $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $savePath = $folderName.'/'.$newFileName;
        Storage::disk('local')->put(
            $savePath,
            file_get_contents($file->getRealPath())
        );

        return date('Ymd').'/'.$newFileName;
    }
}
