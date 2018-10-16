<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 17:06
 */
namespace App\Http\Controllers\Admin\familydoctor;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminBaseController;
use App\Models\familydoctor\Community;
use App\Models\core\Hospital;
use App\Models\familydoctor\Service;
use App\Models\familydoctor\Team;
use App\Models\familydoctor\Doctor;
use App\Http\Requests\familydoctor\CommunityRequest;
use Atorscho\Crumbs\CrumbsFacade;

class CommunityController extends AdminBaseController
{
    public function __construct() {

        CrumbsFacade::add("admin", "主页");
        parent::__construct();
    }

    public function getList (Request $request) {
        $name = $request->input('name');
        $status = $request->input('status');

        $where = [];
        if ($name) {
            $where[] = ['name', 'like', '%'.$name.'%'];
        }
        if (in_array($status, ['0', '1', '-1'])) {
            $where[] = ['status', '=', $status];
        }
        $community_list = Community::where($where)->orderBy('created_at', 'desc')->paginate(config('admin.pageNum'));


        CrumbsFacade::addCurrent("社区列表");
        return view('admin.fd-community.list', [
            'community_list' => $community_list,
        ]);
    }

    public function getAdd () {
        $hospital_list = Hospital::get();
        $paid_service_tags = Service::where('type', '=', 1)->get();
        $unpaid_service_tags = Service::where('type', '=', 2)->get();


        CrumbsFacade::add(route('admin.familydoctor.community.list'), "社区列表");
        CrumbsFacade::addCurrent("新增社区");
        return view('admin.fd-community.add', [
            'hospital_list'       => $hospital_list,
            'paid_service_tags'   => $paid_service_tags,
            'unpaid_service_tags' => $unpaid_service_tags,
        ]);
    }

    public function ajaxGetAddTag (Request $request) {
        $name = $request->input('name');
        if (is_numeric($name)) exit;
        $type = $request->input('type');

        $count = Service::where('name', '=', $name)->where('type', '=', $type)->count();

        if ($count==0 && ! empty(trim($name))) {
            $data['name'] = $name;
            $data['type'] = $type;

            if ($model = Service::create($data)) {
                return response()->json($model->id);
            } else {
                return response()->json(2);
            }
        } else {
            return response()->json(0);
        }
    }

    public function postAdd (CommunityRequest $request) {
        //dd($request->hasFile('contact_qrcode'));
        //dd($request->all());
        $data = $request->except('_token');

        // logos
//        if ($request->hasFile('logos')) {
//            $logos_array = $request->file('logos');
//            $logos_url_array = [];
//            foreach ($logos_array as $logos_item) {
//                $logos_url_array[] = $this->uploadSingleFile($logos_item);
//            }
//            $data['logos'] = serialize($logos_url_array);
//        } else {
//            $data['logos'] = '';
//        }
        $logos_array = array_filter($request->input('logos')); // 去掉空值
        $data['logos'] = serialize($logos_array);

        // contacts
//        if ($request->hasFile('contact_qrcode')) {
//            $contacts_array = $request->file('contact_qrcode');
//            $contacts_url_array = [];
//            foreach ($contacts_array as $contacts_item) {
//                $contacts_url_array[] = $this->uploadSingleFile($contacts_item);
//            }
//            $data['contact_qrcode'] = serialize($contacts_url_array);
//            //$data['contact_phone'] = serialize($request->input('contact_phone'));
//        } else {
//            $data['contact_qrcode'] = '';
//            //$data['contact_phone'] = '';
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

        // services
        if (isset($data['paid_service_tag'])) {
            foreach ($data['paid_service_tag'] as $k => $v) {
                if (! is_numeric($v)) {
                    $tag = Service::where('name', '=', $v)->where('type', '=', 1)->first();
                    $data['paid_service_tag'][$k] = $tag['id'];
                }
            }
            $data['paid_service_tag'] = implode(',', $data['paid_service_tag']);
        }
        if (isset($data['unpaid_service_tag'])) {
            foreach ($data['unpaid_service_tag'] as $k => $v) {
                if (! is_numeric($v)) {
                    $tag = Service::where('name', '=', $v)->where('type', '=', 2)->first();
                    $data['unpaid_service_tag'][$k] = $tag['id'];
                }
            }
            $data['unpaid_service_tag'] = implode(',', $data['unpaid_service_tag']);
        }


        if (Community::create($data) instanceof Community) {
            return redirect()->route('admin.familydoctor.community.list')->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getEdit ($id) {
        $community = Community::findOrFail($id);
        $hospital_list = Hospital::get();
        $paid_service_tags = Service::where('type', '=', 1)->get();
        $unpaid_service_tags = Service::where('type', '=', 2)->get();

        CrumbsFacade::add(route('admin.familydoctor.community.list'), "社区列表");
        CrumbsFacade::addCurrent("编辑社区");
        return view('admin.fd-community.edit', [
            'community'            => $community,
            'hospital_list'        => $hospital_list,
            'paid_service_tags'    => $paid_service_tags,
            'unpaid_service_tags'  => $unpaid_service_tags,
            '_paid_service_tags'   => explode(',', $community->paid_service_tag),
            '_unpaid_service_tags' => explode(',', $community->unpaid_service_tag),
            'contact_phones'       => unserialize($community->contact_phone),
            'contact_qrcodes'      => unserialize($community->contact_qrcode),
            //'contact_loop'         => unserialize($community->contact_phone)==false ? unserialize($community->contact_qrcode) : unserialize($community->contact_phone),
            'logos'                => unserialize($community->logos),
        ]);
    }

    public function postEdit (Request $request) {
        //dd($request->all());
        $id = $request->input('id');

        $this->validate($request, [
            'name'        => 'required|max:255|unique:fd_community,name,'.$id,
            'hospital_id' => 'required|numeric',
            'status'      => 'required|in:0,1,-1',
        ], [
            'name.required'        => '社区名称不能为空',
            'name.max'             => '社区名称长度不能超过255',
            'name.unique'          => '社区名称不能重复',
            'hospital_id.required' => '医院id不能为空',
            'hospital_id.numeric'  => '医院id必须是数字',
            'status.required'      => '状态值不能为空',
            'status.in'            => '状态值只能是0或者1或者-1',
        ]);


        $data = $request->except('_token', 'id');

        // logos
//        if (isset($data['_logos'])) {
//            if ($request->hasFile('logos')) {
//                if (count($data['_logos'])==count($data['logos'])) {
//                    $new_logos_array = $request->file('logos');
//                    foreach ($new_logos_array as $key => $new_logos_item) {
//                        if ($new_logos_item!=null) {
//                            $data['_logos'][$key] = $this->uploadSingleFile($new_logos_item);
//                        }
//                    }
//                } else {
//                    $new_logos_array = $request->file('logos');
//                    foreach ($new_logos_array as $new_logos_item) {
//                        if ($new_logos_item!=null) {
//                            $data['_logos'][] = $this->uploadSingleFile($new_logos_item);
//                        }
//                    }
//                }
//            }
//            $data['logos'] = serialize($data['_logos']);
//            unset($data['_logos']);
//        } else {
//            $data['logos'] = '';
//        }
        $logos_array = array_filter($request->input('logos')); // 去掉空值
        $data['logos'] = serialize($logos_array);

        // contacts
//        if (isset($data['_contact_qrcode'])) {
//            if ($request->hasFile('contact_qrcode')) {
//                if (count($data['_contact_qrcode'])==count($data['contact_qrcode'])) {
//                    $new_contacts_array = $request->file('contact_qrcode');
//                    foreach ($new_contacts_array as $key => $new_contacts_item) {
//                        if ($new_contacts_item!=null) {
//                            $data['_contact_qrcode'][$key] = $this->uploadSingleFile($new_contacts_item);
//                        }
//                    }
//                } else {
//                    $new_contacts_array = $request->file('contact_qrcode');
//                    foreach ($new_contacts_array as $new_contacts_item) {
//                        if ($new_contacts_item!=null) {
//                            $data['_contact_qrcode'][] = $this->uploadSingleFile($new_contacts_item);
//                        }
//                    }
//                }
//            }
//            $data['contact_qrcode'] = serialize($data['_contact_qrcode']);
//            $data['contact_phone'] = serialize($data['contact_phone']);
//            unset($data['_contact_qrcode']);
//        } else {
//            $data['contact_qrcode'] = '';
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

        // services
        if (isset($data['paid_service_tag'])) {
            foreach ($data['paid_service_tag'] as $k => $v) {
                if (! is_numeric($v)) {
                    $tag = Service::where('name', '=', $v)->where('type', '=', 1)->first();
                    $data['paid_service_tag'][$k] = $tag['id'];
                }
            }
            $data['paid_service_tag'] = implode(',', $data['paid_service_tag']);
        } else {
            $data['paid_service_tag'] = '';
        }
        if (isset($data['unpaid_service_tag'])) {
            foreach ($data['unpaid_service_tag'] as $k => $v) {
                if (! is_numeric($v)) {
                    $tag = Service::where('name', '=', $v)->where('type', '=', 2)->first();
                    $data['unpaid_service_tag'][$k] = $tag['id'];
                }
            }
            $data['unpaid_service_tag'] = implode(',', $data['unpaid_service_tag']);
        } else {
            $data['unpaid_service_tag'] = '';
        }


        if (Community::where('id', '=', $id)->update($data)) {
            return redirect()->route('admin.familydoctor.community.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getDelete ($id) {
        if (Team::where('community_id', '=', $id)->first()) {
            return back()->with('warning', '有团队关联，删除失败');
        }

        if (Doctor::where('community_id', '=', $id)->first()) {
            return back()->with('warning', '有医生关联，删除失败');
        }

        if (Community::where('id', '=', $id)->delete()) {
            return redirect()->route('admin.familydoctor.community.list')->with('suc', '删除成功');
        } else {
            return back()->with('fail', '删除失败');
        }
    }
}