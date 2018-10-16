<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 17:06
 */
namespace App\Http\Controllers\Admin\familydoctor;

use App\Http\Controllers\AdminBaseController;
use App\Models\familydoctor\Community;
use App\Http\Requests\familydoctor\TeamRequest;
use App\Models\familydoctor\Doctor;
use App\Models\familydoctor\Team;
use Illuminate\Http\Request;
use Atorscho\Crumbs\CrumbsFacade;

class TeamController extends AdminBaseController
{
    public function __construct() {

        CrumbsFacade::add("admin", "主页");
        parent::__construct();
    }

    public function getList (Request $request) {
        $community_id = $request->input('community_id');
        $name = $request->input('name');
        $status = $request->input('status');

        $where = [];
        if ($community_id) {
            $where[] = ['community_id', '=', $community_id];
        }
        if ($name) {
            $where[] = ['name', 'like', '%'.$name.'%'];
        }
        if (in_array($status, ['0', '1', '-1'])) {
            $where[] = ['status', '=', $status];
        }
        $team_list = Team::where($where)->orderBy('created_at', 'desc')->paginate(config('admin.pageNum'));
        $community_list = Community::get();


        CrumbsFacade::addCurrent("团队列表");
        return view('admin.fd-team.list', [
            'team_list'      => $team_list,
            'community_list' => $community_list,
        ]);
    }

    public function getAdd () {
        $community_list = Community::get();

        CrumbsFacade::add(route('admin.familydoctor.team.list'), "团队列表");
        CrumbsFacade::addCurrent("新增团队");
        return view('admin.fd-team.add', [
            'community_list' => $community_list,
        ]);
    }

    public function postAdd (TeamRequest $request) {
        //dd($request->all());
        $data = $request->except('_token');

        // photos
//        if ($request->hasFile('photos')) {
//            $photos_array = $request->file('photos');
//            $photos_url_array = [];
//            foreach ($photos_array as $photos_item) {
//                $photos_url_array[] = $this->uploadSingleFile($photos_item);
//            }
//            $data['photos'] = serialize($photos_url_array);
//        } else {
//            $data['photos'] = '';
//        }
        $photos_array = array_filter($request->input('photos')); // 去掉空值
        $data['photos'] = serialize($photos_array);

        // contacts
//        if ($request->hasFile('contact_qrcode')) {
//            $contacts_array = $request->file('contact_qrcode');
//            $contacts_url_array = [];
//            foreach ($contacts_array as $contacts_item) {
//                $contacts_url_array[] = $this->uploadSingleFile($contacts_item);
//            }
//            $data['contact_qrcode'] = serialize($contacts_url_array);
//        } else {
//            $data['contact_qrcode'] = '';
//        }
//        if (isset($data['contact_phone'])&&$data['contact_phone'][0]!='') {
//            $data['contact_phone'] = serialize($data['contact_phone']);
//        } else {
//            $data['contact_phone'] = '';
//        }
        $contact_qrcode_array = $request->input('contact_qrcode');
        $contact_phone_array = $request->input('contact_phone');
        foreach ($contact_qrcode_array as $key => $contact_qrcode_item) {
            if ($contact_qrcode_item==''&&$contact_phone_array[$key]=='') {
                unset($contact_qrcode_array[$key]);
                unset($contact_phone_array[$key]);
            }
        }
        $data['contact_qrcode'] = serialize($contact_qrcode_array);
        $data['contact_phone'] = serialize($contact_phone_array);


        if (Team::create($data) instanceof Team) {
            return redirect()->route('admin.familydoctor.team.list')->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getEdit ($id) {
        $team = Team::findOrFail($id);
        $community_list = Community::get();

        CrumbsFacade::add(route('admin.familydoctor.team.list'), "团队列表");
        CrumbsFacade::addCurrent("编辑团队");
        return view('admin.fd-team.edit', [
            'team'            => $team,
            'community_list'  => $community_list,
            'photos'          => unserialize($team->photos),
            'contact_phones'  => unserialize($team->contact_phone),
            'contact_qrcodes' => unserialize($team->contact_qrcode),
            //'contact_loop'    => unserialize($team->contact_phone)==false ? unserialize($team->contact_qrcode) : unserialize($team->contact_phone),
        ]);
    }

    public function postEdit (TeamRequest $request) {
        //dd($request->all());
        $id = $request->input('id');

        $data = $request->except('_token', 'id');

        // photos
//        if (isset($data['_photos'])) {
//            if ($request->hasFile('photos')) {
//                if (count($data['_photos'])==count($data['photos'])) {
//                    $new_photos_array = $request->file('photos');
//                    foreach ($new_photos_array as $key => $new_photos_item) {
//                        if ($new_photos_item!=null) {
//                            $data['_photos'][$key] = $this->uploadSingleFile($new_photos_item);
//                        }
//                    }
//                } else {
//                    $new_photos_array = $request->file('photos');
//                    foreach ($new_photos_array as $new_photos_item) {
//                        if ($new_photos_item!=null) {
//                            $data['_photos'][] = $this->uploadSingleFile($new_photos_item);
//                        }
//                    }
//                }
//            }
//            $data['photos'] = serialize($data['_photos']);
//            unset($data['_photos']);
//        } else {
//            $data['photos'] = '';
//        }
        $photos_array = array_filter($request->input('photos')); // 去掉空值
        $data['photos'] = serialize($photos_array);

        // contacts
        $contact_qrcode_array = $request->input('contact_qrcode');
        $contact_phone_array = $request->input('contact_phone');
        foreach ($contact_qrcode_array as $key => $contact_qrcode_item) {
            if ($contact_qrcode_item==''&&$contact_phone_array[$key]=='') {
                unset($contact_qrcode_array[$key]);
                unset($contact_phone_array[$key]);
            }
        }
        $data['contact_qrcode'] = serialize($contact_qrcode_array);
        $data['contact_phone'] = serialize($contact_phone_array);


        if (Team::where('id', '=', $id)->update($data)) {
            return redirect()->route('admin.familydoctor.team.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getDelete ($id) {
        if (Doctor::where('team_id', '=', $id)->first()) {
            return back()->with('warning', '有医生关联，删除失败');
        }

        if (Team::where('id', '=', $id)->delete()) {
            return redirect()->route('admin.familydoctor.team.list')->with('suc', '删除成功');
        } else {
            return back()->with('fail', '删除失败');
        }
    }
}