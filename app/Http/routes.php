<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => 'web'], function () {
    /**
     * below are the routes of app.
     */
    Route::auth();

    // just for test.
    Route::get('test', ['middleware' => 'auth.basic', 'uses'=>'Home\TestController@getIndex', 'as'=>'home.test.getIndex']);

    // vote.
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    //Route::group(['prefix' => 'vote', 'middleware' => ["wechatauth:admin,".$id]], function () use ($id) {
    Route::group(['prefix' => 'vote'], function () use ($id) {
        Route::group(['middleware' => ["cdn:".$id]], function () use($id) {
            Route::get('index', ['uses'=>'Home\v'.$id.'\VoteController@getIndex', 'as'=>'home.vote.getIndex'.$id]);
            Route::get('info/{cid}', ['uses'=>'Home\v'.$id.'\VoteController@getInfo', 'as'=>'home.vote.getInfo'.$id]);
            Route::get('rank', ['uses'=>'Home\v'.$id.'\VoteController@getRank', 'as'=>'home.vote.getRank'.$id]);
            Route::get('register', ['uses'=>'Home\v'.$id.'\VoteController@getRegister', 'as'=>'home.vote.getRegister'.$id]);
            //Route::get('register-edit', ['uses'=>'Home\v'.$id.'\VoteController@getRegisterEdit', 'as'=>'home.vote.getRegisterEdit'.$id]);
            Route::get('log', ['uses'=>'Home\v'.$id.'\VoteController@getLog', 'as'=>'home.vote.getLog'.$id]);
            Route::get('theme1', ['uses'=>'Home\v'.$id.'\VoteController@getTheme1', 'as'=>'home.vote.getTheme1'.$id]);
            Route::get('theme2', ['uses'=>'Home\v'.$id.'\VoteController@getTheme2', 'as'=>'home.vote.getTheme2'.$id]);
            Route::get('redpack', ['uses'=>'Home\v'.$id.'\VoteController@getRedpack', 'as'=>'home.vote.getRedpack'.$id]);
        });
        Route::get('do-vote/{cid}/{wid}', ['uses'=>'Home\v'.$id.'\VoteController@getDoVote', 'as'=>'home.vote.getDoVote'.$id]);
        Route::post('do-register', ['uses'=>'Home\v'.$id.'\VoteController@getDoRegister', 'as'=>'home.vote.getDoRegister'.$id]);
        Route::post('do-register-edit', ['uses'=>'Home\v'.$id.'\VoteController@getDoRegisterEdit', 'as'=>'home.vote.getDoRegisterEdit'.$id]);
        Route::post('do-sth-by-type', ['uses'=>'Home\v'.$id.'\VoteController@postDoSthByType', 'as'=>'home.vote.postDoSthByType'.$id]);
        //Route::post('do-comment/{cid}/{wid}', ['uses'=>'Home\v'.$id.'\VoteController@getDoVoteComment', 'as'=>'home.vote.getDoVoteComment'.$id]);
    });
    Route::get('captcha', ['uses'=>'HomeBaseController@getCaptcha', 'as'=>'base.getCaptcha']);
    Route::post('upload', ['uses'=>'HomeBaseController@postUpload', 'as'=>'base.postUpload']);
    
    //Route::get('form/register', ['uses'=>'Home\FormController@getRegister', 'as'=>'home.form.getRegister']);
    //Route::get('form/do-register', ['uses'=>'Home\FormController@getDoRegister', 'as'=>'home.form.getDoRegister']);
    //Route::post('form/upload', ['uses'=>'HomeBase2Controller@postUpload', 'as'=>'base2.postUpload']);

    // brush vote
    Route::get('brush/index', ['uses'=>'Home\BrushController@getIndex', 'as'=>'home.brush.getIndex']);
    Route::get('brush/do-index', ['uses'=>'Home\BrushController@getDoIndex', 'as'=>'home.brush.getDoIndex']);




    /**
     * below are the routes of admin.
     */
    Route::group(['prefix' => 'admin', 'middleware' => ['pjax']], function () {
        // register and login.
        Route::get('login', ['uses'=>'Admin\AuthController@getLogin', 'as'=>'admin.getLogin']);
        Route::post('login', ['uses'=>'Admin\AuthController@postLogin', 'as'=>'admin.postLogin']);
        Route::get('logout', ['uses'=>'Admin\AuthController@logout', 'as'=>'admin.logout']);
        //Route::get('register', 'Admin\AuthController@getRegister');
        //Route::post('register', 'Admin\AuthController@postRegister');

        // dashboard.
        Route::get('/', 'Admin\IndexController@index');

        // password change.
        Route::post('change-password', ['uses'=>'Admin\IndexController@postChgPwd', 'as'=>'admin.postChgPwd']);

        Route::group(['middleware' => ['role.check:admin']], function() {
            // permissions.
            Route::group(['prefix' => 'permission'], function () {
                Route::get('list', ['uses'=>'Admin\PermissionController@getList', 'as'=>'admin.permission.list']);
                Route::get('add', ['uses'=>'Admin\PermissionController@getAdd', 'as'=>'admin.permission.getAdd']);
                Route::post('add', ['uses'=>'Admin\PermissionController@postAdd', 'as'=>'admin.permission.postAdd']);
                Route::get('edit/{id}', ['uses'=>'Admin\PermissionController@getEdit', 'as'=>'admin.permission.getEdit']);
                Route::post('edit', ['uses'=>'Admin\PermissionController@postEdit', 'as'=>'admin.permission.postEdit']);
                Route::get('delete/{id}', ['uses'=>'Admin\PermissionController@getDelete', 'as'=>'admin.permission.getDelete']);
            });

            // role.
            Route::group(['prefix' => 'role'], function () {
                Route::get('list', ['uses'=>'Admin\RoleController@getList', 'as'=>'admin.role.list']);
                Route::get('add', ['uses'=>'Admin\RoleController@getAdd', 'as'=>'admin.role.getAdd']);
                Route::post('add', ['uses'=>'Admin\RoleController@postAdd', 'as'=>'admin.role.postAdd']);
                Route::get('edit/{id}', ['uses'=>'Admin\RoleController@getEdit', 'as'=>'admin.role.getEdit']);
                Route::post('edit', ['uses'=>'Admin\RoleController@postEdit', 'as'=>'admin.role.postEdit']);
                Route::get('delete/{id}', ['uses'=>'Admin\RoleController@getDelete', 'as'=>'admin.role.getDelete']);
                Route::get('attach-permission/{id}', ['uses'=>'Admin\RoleController@getAttachPermission', 'as'=>'admin.role.getAttachPermission']);
                Route::post('attach-permission', ['uses'=>'Admin\RoleController@postAttachPermission', 'as'=>'admin.role.postAttachPermission']);
            });

            // user.
            Route::group(['prefix' => 'user'], function () {
                Route::get('list', ['uses'=>'Admin\AdminController@getList', 'as'=>'admin.admin.list']);
                Route::get('add', ['uses'=>'Admin\AdminController@getAdd', 'as'=>'admin.admin.getAdd']);
                Route::post('add', ['uses'=>'Admin\AdminController@postAdd', 'as'=>'admin.admin.postAdd']);
                Route::get('edit/{id}', ['uses'=>'Admin\AdminController@getEdit', 'as'=>'admin.admin.getEdit']);
                Route::post('edit', ['uses'=>'Admin\AdminController@postEdit', 'as'=>'admin.admin.postEdit']);
                Route::get('delete/{id}', ['uses'=>'Admin\AdminController@getDelete', 'as'=>'admin.admin.getDelete']);
                Route::get('attach-role/{id}', ['uses'=>'Admin\AdminController@getAttachRole', 'as'=>'admin.admin.getAttachRole']);
                Route::post('attach-role', ['uses'=>'Admin\AdminController@postAttachRole', 'as'=>'admin.admin.postAttachRole']);
            });
        });

        // file.
        Route::post('file/upload', ['uses'=>'Admin\FileController@postUploadFile', 'as'=>'admin.file.postUploadFile']);

        // video.
        Route::post('video/upload', ['uses'=>'Admin\FileController@postUploadVideo', 'as'=>'admin.file.postUploadVideo']);

        // excel.
        Route::get('excel/import', ['uses'=>'Admin\ExcelController@getImport', 'as'=>'admin.excel.getImport']);
        Route::post('excel/import', ['uses'=>'Admin\ExcelController@postImport', 'as'=>'admin.excel.postImport']);
        Route::get('excel/export', ['uses'=>'Admin\ExcelController@getExport', 'as'=>'admin.excel.getExport']);

        // we define this url to suit the delete javascript.
        Route::get('candidate/delete/{id}', ['uses'=>'Admin\VoteController@getCandidateDelete', 'as'=>'admin.vote.getCandidateDelete']);

        Route::group(['prefix' => 'vote'], function () {
            // vote.
            Route::get('list', ['uses'=>'Admin\VoteController@getList', 'as'=>'admin.vote.list']);
            Route::get('add', ['uses'=>'Admin\VoteController@getAdd', 'as'=>'admin.vote.getAdd']);
            Route::post('add', ['uses'=>'Admin\VoteController@postAdd', 'as'=>'admin.vote.postAdd']);
            Route::get('edit/{id}', ['uses'=>'Admin\VoteController@getEdit', 'as'=>'admin.vote.getEdit']);
            Route::post('edit', ['uses'=>'Admin\VoteController@postEdit', 'as'=>'admin.vote.postEdit']);
            Route::get('baseinfo/{id}', ['uses'=>'Admin\VoteController@getBaseinfo', 'as'=>'admin.vote.getBaseinfo']);
            Route::post('baseinfo', ['uses'=>'Admin\VoteController@postBaseinfo', 'as'=>'admin.vote.postBaseinfo']);
            Route::get('config/{id}', ['uses'=>'Admin\VoteController@getConfig', 'as'=>'admin.vote.getConfig']);
            Route::post('config', ['uses'=>'Admin\VoteController@postConfig', 'as'=>'admin.vote.postConfig']);
            Route::get('manage/{id}', ['uses'=>'Admin\VoteController@getManage', 'as'=>'admin.vote.getManage']);
            Route::post('manage', ['uses'=>'Admin\VoteController@postManage', 'as'=>'admin.vote.postManage']);
            Route::post('throttle-white-list', ['uses'=>'Admin\VoteController@postThrottleWhiteList', 'as'=>'admin.vote.postThrottleWhiteList']);
            Route::post('throttle-white-remove', ['uses'=>'Admin\VoteController@postThrottleWhiteRemove', 'as'=>'admin.vote.postThrottleWhiteRemove']);
            Route::post('throttle-white-add', ['uses'=>'Admin\VoteController@postThrottleWhiteAdd', 'as'=>'admin.vote.postThrottleWhiteAdd']);
            Route::get('delete/{id}', ['uses'=>'Admin\VoteController@getDelete', 'as'=>'admin.vote.getDelete']);
            // candidates.
            Route::get('{id}/candidate-list', ['uses'=>'Admin\VoteController@getCandidateList', 'as'=>'admin.vote.getCandidateList']);
            Route::get('{id}/extend-field-list', ['uses'=>'Admin\VoteController@getExtendFieldList', 'as'=>'admin.vote.getExtendFieldList']);
            Route::get('{id}/extend-field-add', ['uses'=>'Admin\VoteController@getExtendFieldAdd', 'as'=>'admin.vote.getExtendFieldAdd']);
            Route::get('{id}/extend-field-edit/{fid}', ['uses'=>'Admin\VoteController@getExtendFieldEdit', 'as'=>'admin.vote.getExtendFieldEdit']);
            Route::post('extend-field-edit', ['uses'=>'Admin\VoteController@postExtendFieldEdit', 'as'=>'admin.vote.postExtendFieldEdit']);
            Route::post('{id}/extend-field-add', ['uses'=>'Admin\VoteController@postExtendFieldAdd', 'as'=>'admin.vote.postExtendFieldAdd']);
            Route::get('{id}/candidate-add', ['uses'=>'Admin\VoteController@getCandidateAdd', 'as'=>'admin.vote.getCandidateAdd']);
            Route::post('candidate-add', ['uses'=>'Admin\VoteController@postCandidateAdd', 'as'=>'admin.vote.postCandidateAdd']);
            Route::get('{id}/candidate-export', ['uses'=>'Admin\VoteController@getCandidateExport', 'as'=>'admin.vote.getCandidateExport']);
            Route::post('{id}/candidate-import', ['uses'=>'Admin\VoteController@postCandidateImport', 'as'=>'admin.vote.postCandidateImport']);
            // in fact, we only need cid(candidate_id) to edit the candidate,
            // but in order to beautify the url, we just add the id argument.
            Route::get('{id}/candidate-edit/{cid}', ['uses'=>'Admin\VoteController@getCandidateEdit', 'as'=>'admin.vote.getCandidateEdit']);
            Route::post('candidate-edit', ['uses'=>'Admin\VoteController@postCandidateEdit', 'as'=>'admin.vote.postCandidateEdit']);
            Route::get('{id}/candidate-change-status/{cid}/{status}', ['uses'=>'Admin\VoteController@getCandidateChangeStatus', 'as'=>'admin.vote.getCandidateChangeStatus']);
            Route::get('{id}/candidate-vote-history/{cid}', ['uses'=>'Admin\VoteController@getCandidateVoteHistory', 'as'=>'admin.vote.getCandidateVoteHistory']);
            Route::get('{id}/voter-list/{cid}', ['uses'=>'Admin\VoteController@getVoterList', 'as'=>'admin.vote.getVoterList']);
            Route::get('{id}/candidate-vote-manage/{cid}', ['uses'=>'Admin\VoteController@getCandidateVoteManage', 'as'=>'admin.vote.getCandidateVoteManage']);
            Route::post('candidate-vote-manage', ['uses'=>'Admin\VoteController@postCandidateVoteManage', 'as'=>'admin.vote.postCandidateVoteManage']);
            Route::get('{id}/vote-list/{wid}', ['uses'=>'Admin\VoteController@getVoteList', 'as'=>'admin.vote.getVoteList']);
            
            //comment
            Route::get('{id}/comment-list', ['uses'=>'Admin\VoteController@getCommetList', 'as'=>'admin.vote.getCommetList']);
            Route::get('{id}/comment-edit/{cid}/{tid}', ['uses'=>'Admin\VoteController@getCommetEdit', 'as'=>'admin.vote.getCommetEdit']);
        });

        /*************************** haodoctor ***********************/
        // hospital.
        Route::group(['prefix' => 'hospital'], function () {
            Route::get('list', ['uses'=>'Admin\core\HospitalController@getList', 'as'=>'admin.hospital.list']);
            Route::get('add', ['uses'=>'Admin\core\HospitalController@getAdd', 'as'=>'admin.hospital.getAdd']);
            Route::post('add', ['uses'=>'Admin\core\HospitalController@postAdd', 'as'=>'admin.hospital.postAdd']);
            Route::get('edit/{id}', ['uses'=>'Admin\core\HospitalController@getEdit', 'as'=>'admin.hospital.getEdit']);
            Route::post('edit', ['uses'=>'Admin\core\HospitalController@postEdit', 'as'=>'admin.hospital.postEdit']);
            Route::get('delete/{id}', ['uses'=>'Admin\core\HospitalController@getDelete', 'as'=>'admin.hospital.getDelete']);
        });

        // department.
        Route::group(['prefix' => 'department'], function () {
            Route::get('list', ['uses'=>'Admin\core\DepartmentController@getList', 'as'=>'admin.department.list']);
            Route::get('add', ['uses'=>'Admin\core\DepartmentController@getAdd', 'as'=>'admin.department.getAdd']);
            Route::post('add', ['uses'=>'Admin\core\DepartmentController@postAdd', 'as'=>'admin.department.postAdd']);
            Route::get('edit/{id}', ['uses'=>'Admin\core\DepartmentController@getEdit', 'as'=>'admin.department.getEdit']);
            Route::post('edit', ['uses'=>'Admin\core\DepartmentController@postEdit', 'as'=>'admin.department.postEdit']);
            Route::get('delete/{id}', ['uses'=>'Admin\core\DepartmentController@getDelete', 'as'=>'admin.department.getDelete']);
        });

        // doctor.
        Route::group(['prefix' => 'doctor'], function () {
            Route::get('list', ['uses'=>'Admin\core\DoctorController@getList', 'as'=>'admin.doctor.list']);
            Route::get('ajax-deps/{hid}', ['uses'=>'Admin\core\DoctorController@ajaxGetDeps', 'as'=>'admin.doctor.ajax-deps']);
            Route::get('ajax-add-tag/{name}', ['uses'=>'Admin\core\DoctorController@ajaxGetAddTag', 'as'=>'admin.doctor.ajax-add-tag']);
            Route::get('add', ['uses'=>'Admin\core\DoctorController@getAdd', 'as'=>'admin.doctor.getAdd']);
            Route::post('add', ['uses'=>'Admin\core\DoctorController@postAdd', 'as'=>'admin.doctor.postAdd']);
            Route::get('edit/{id}', ['uses'=>'Admin\core\DoctorController@getEdit', 'as'=>'admin.doctor.getEdit']);
            Route::post('edit', ['uses'=>'Admin\core\DoctorController@postEdit', 'as'=>'admin.doctor.postEdit']);
            Route::get('delete/{id}', ['uses'=>'Admin\core\DoctorController@getDelete', 'as'=>'admin.doctor.getDelete']);
        });


        /******************* family doctor **********************/
        // community.
        Route::group(['prefix' => 'fd-community'], function () {
            Route::get('list', ['uses' => 'Admin\familydoctor\CommunityController@getList', 'as' => 'admin.familydoctor.community.list']);
            Route::get('add', ['uses' => 'Admin\familydoctor\CommunityController@getAdd', 'as' => 'admin.familydoctor.community.getAdd']);
            Route::post('add', ['uses' => 'Admin\familydoctor\CommunityController@postAdd', 'as' => 'admin.familydoctor.community.postAdd']);
            Route::get('ajax-add-tag', ['uses'=>'Admin\familydoctor\CommunityController@ajaxGetAddTag', 'as'=>'admin.familydoctor.community.ajax-add-tag']);
            Route::get('edit/{id}', ['uses' => 'Admin\familydoctor\CommunityController@getEdit', 'as' => 'admin.familydoctor.community.getEdit']);
            Route::post('edit', ['uses' => 'Admin\familydoctor\CommunityController@postEdit', 'as' => 'admin.familydoctor.community.postEdit']);
            Route::get('delete/{id}', ['uses' => 'Admin\familydoctor\CommunityController@getDelete', 'as' => 'admin.familydoctor.community.getDelete']);
        });

        // team.
        Route::group(['prefix' => 'fd-team'], function () {
            Route::get('list', ['uses' => 'Admin\familydoctor\TeamController@getList', 'as' => 'admin.familydoctor.team.list']);
            Route::get('add', ['uses' => 'Admin\familydoctor\TeamController@getAdd', 'as' => 'admin.familydoctor.team.getAdd']);
            Route::post('add', ['uses' => 'Admin\familydoctor\TeamController@postAdd', 'as' => 'admin.familydoctor.team.postAdd']);
            Route::get('edit/{id}', ['uses' => 'Admin\familydoctor\TeamController@getEdit', 'as' => 'admin.familydoctor.team.getEdit']);
            Route::post('edit', ['uses' => 'Admin\familydoctor\TeamController@postEdit', 'as' => 'admin.familydoctor.team.postEdit']);
            Route::get('delete/{id}', ['uses' => 'Admin\familydoctor\TeamController@getDelete', 'as' => 'admin.familydoctor.team.getDelete']);
        });

        // doctor.
        Route::group(['prefix' => 'fd-doctor'], function () {
            Route::get('list', ['uses' => 'Admin\familydoctor\DoctorController@getList', 'as' => 'admin.familydoctor.doctor.list']);
            Route::get('ajax-teams/{cid}', ['uses'=>'Admin\familydoctor\DoctorController@ajaxGetTeams', 'as'=>'admin.familydoctor.doctor.ajax-teams']);
            //Route::post('ajax-avatar', ['uses'=>'Admin\familydoctor\DoctorController@ajaxPostAvatar', 'as'=>'admin.familydoctor.doctor.ajax-avatar']);
            Route::get('add', ['uses' => 'Admin\familydoctor\DoctorController@getAdd', 'as' => 'admin.familydoctor.doctor.getAdd']);
            Route::post('add', ['uses' => 'Admin\familydoctor\DoctorController@postAdd', 'as' => 'admin.familydoctor.doctor.postAdd']);
            Route::get('edit/{id}', ['uses' => 'Admin\familydoctor\DoctorController@getEdit', 'as' => 'admin.familydoctor.doctor.getEdit']);
            Route::post('edit', ['uses' => 'Admin\familydoctor\DoctorController@postEdit', 'as' => 'admin.familydoctor.doctor.postEdit']);
            Route::get('delete/{id}', ['uses' => 'Admin\familydoctor\DoctorController@getDelete', 'as' => 'admin.familydoctor.doctor.getDelete']);
        });
    });
});
