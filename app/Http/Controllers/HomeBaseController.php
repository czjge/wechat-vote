<?php

namespace App\Http\Controllers;

use App\Extensions\captcha\Verify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Extensions\tn\tn;

class HomeBaseController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function getCaptcha (Request $request) {
        $type = $request->input('type');
        if (1 == $type) {
            error_reporting(0);
            $tn  = new tn();
            $tn->make();
            exit;
        }
        if (2 == $type) {
            $tn  = new tn();
            if($tn->check()){
                $_SESSION['tncode_check'] = 'ok';
                echo 'ok';
            }else{
                session()->put('tncode_check', 'error');
                $_SESSION['tncode_check'] = 'error';
                echo "error";
            }
            exit;
        }

        $Verify =  new Verify();
        $Verify->fontSize = 30;
        $Verify->length   = 3;
        $Verify->useNoise = false;
        $Verify->entry();
    }

    public function postUpload (Request $request) {
        $fieldName = $request->input('fileName');
        if ($request->hasFile($fieldName)) {

            // check if folder exists.
            $folderName = 'public/'.date('Ymd');
            if (! Storage::disk('local')->exists($folderName)) {
                Storage::makeDirectory($folderName);
            }

            // get input file.
            $file = $request->file($fieldName);

            // check if the size has exceeded.
            if ($file->getClientSize() > $request->input('Msize')) {
                echo '3';exit;
            }

            // check validation.
            if (! $file->isValid()) {
                echo '2';exit;
            }

            //Save it to Folder.
            $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
            $savePath = $folderName.'/'.$newFileName;
            Storage::disk('local')->put(
                $savePath,
                file_get_contents($file->getRealPath())
            );

            //return response.
            echo '0|' . date('Ymd').'/'.$newFileName;exit;

        } else {
            echo '1';exit;
        }
    }
}
