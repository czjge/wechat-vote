<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/11
 * Time: 11:38
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\vote\Vote;
use Illuminate\Http\Request;
use App\Http\Requests\vote\VoteAddRequest;
use Illuminate\Support\Facades\Storage;


class FileController extends AdminBaseController
{
    public function __construct() {

        parent::__construct();
    }

    public function postUploadFile (Request $request) {
        // if you do not set a name for your file input,
        // bootstrap-fileinput will give a default name 'file_data'
        if ($request->hasFile('file_data')) {

            // check if folder exists
            $folderName = 'public/'.date('Ymd');
            if (! Storage::disk('local')->exists($folderName)) {
                Storage::makeDirectory($folderName);
            }

            // get input file
            $file = $request->file('file_data');

            // check validation
            if (! $file->isValid()) {
                return response()->json(['error'=>'上传文件错误']);
            }

            //Save it to Folder
            $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
            $savePath = $folderName.'/'.$newFileName;
            Storage::disk('local')->put(
                $savePath,
                file_get_contents($file->getRealPath())
            );

            //return response
            return response()->json([
                'success' => '上传文件成功',
                'url' => date('Ymd').'/'.$newFileName,
            ]);

        } else {
            return response()->json(['error'=>'上传文件为空']);
        }
    }

    public function postUploadVideo (Request $request) {
        // if you do not set a name for your file input,
        // bootstrap-fileinput will give a default name 'file_data'
        if ($request->hasFile('file_data')) {

            // check if folder exists
            $folderName = 'public/'.date('Ymd');
            if (! Storage::disk('local')->exists($folderName)) {
                Storage::makeDirectory($folderName);
                //mkdir($folderName, 0755, true);
            }

            // get input file
            $file = $request->file('file_data');

            // check validation
            if (! $file->isValid()) {
                return response()->json(['error'=>'上传文件错误']);
            }

            //Save it to Folder
            $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
            $savePath = $folderName.'/'.$newFileName;
            Storage::disk('local')->put(
                $savePath,
                file_get_contents($file->getRealPath())
            );
            //move_uploaded_file($_FILES['file_data']['tmp_name'], $savePath);

            //return response
            return response()->json([
                'success' => '上传文件成功',
                'url' => date('Ymd').'/'.$newFileName,
            ]);

        } else {
            return response()->json(['error'=>'上传文件为空']);
        }
    }

}