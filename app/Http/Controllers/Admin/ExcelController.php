<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/26
 * Time: 11:19
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Excel;
use DB;
use App\Models\core\Doctor;
use App\Models\core\Department;
use App\Models\core\Hospital;
use App\Models\hao\HosRankDoctor;
use App\Models\hao\PerRankDoctor;
use App\Models\vote\Candidate;
use App\Models\vote\FieldValue;
use App\Models\vote\FieldItem;


class ExcelController extends AdminBaseController
{
    public function __construct() {

        parent::__construct();
    }

    public function getImport () {
        return view('admin.excel.import');
    }

    public function postImport (Request $request) {
        set_time_limit(0);

        Excel::selectSheetsByIndex(0)->load($request->file('file')->getRealPath(), function($reader) {

            // Getting all results.
            $results = $reader->get();
            //dd($results);

//        $not_found_doctors_id_string = '';
//        $found_doctors_count = 0;
//        foreach ($results as $item) {
//            $doctor_id = (int) $item->id;
//            //dd($doctor_id);
//
//            $doctor = DB::table('hys_px_doctor')
//                        ->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hys_px_doctor.hid')
//                        ->leftJoin('hys_px_department', 'hys_px_department.id', '=', 'hys_px_doctor.department_id')
//                        ->where('hys_px_doctor.id', '=', $doctor_id)
//                        ->select('hys_px_hospital.name as hname',
//                                'hys_px_department.name as dname',
//                                'hys_px_doctor.name',
//                                'hys_px_doctor.prof as title',
//                                'hys_px_doctor.avatar',
//                                'hys_px_doctor.intro',
//                                'hys_px_doctor.shanchang as goodat',
//                                'hys_px_doctor.schedule_time',
//                            'hys_px_hospital.id as hid',
//                            'hys_px_department.id as did',
//                            'hys_px_doctor.id as doid')
//                        ->first();
//            //dd($doctor);
//
//            if (! $doctor) {
//                $not_found_doctors_id_string .= ($not_found_doctors_id_string!='' ? ',' : '') . $doctor_id;
//                continue;
//            }
//
//            HosRankDoctor::create([
//                'hospital' => $doctor->hname,
//                'department' => $doctor->dname,
//                'name' => $doctor->name,
//                'title' => $doctor->title,
//                'avatar' => $doctor->avatar,
//                'intro' => $doctor->intro,
//                'goodat' => $doctor->goodat,
//                'schedule_time' => $doctor->schedule_time,
//                'hospital_id' => $doctor->hid,
//                'department_id' => $doctor->did,
//                'doctor_id' => $doctor->doid,
//            ]);
//            $found_doctors_count++;
//
//        }
//
//
//        dd('此次共导入医生：'.$found_doctors_count.'名。数据库中未找到医生的id是：'.$not_found_doctors_id_string);


//            foreach ($results as $item) {
//                if ($item->no==null) {
//                    continue;
//                }
//                if ((int) $item->no==3||(int) $item->no==14) {
//                    $has_video = 1;
//                } else {
//                    $has_video = 0;
//                }
//                Candidate::create([
//                    'vote_id' => 4,
//                    'no' => (int) $item->no,
//                    'name' => $item->name,
//                    'desc' => $item->desc,
//                    'of_dep' => $item->of_dep,
//                    'composer' => $item->composer==null ? '' : $item->composer,
//                    'singer' => $item->singer,
//                    'audio_type' => $item->audio_type,
//                    'has_video' => $has_video,
//                ]);
//            }
//
//            dd('ok');


            $not_found_doctors_id_string = '';
            $found_doctors_count = 0;
            $no = 1;
            $field_item_list = FieldItem::where('vote_id', '=', 5)->get();
            //dd($field_item_list);

            DB::beginTransaction();
            foreach ($results as $item) {
                $doctor_id = (int) $item->id;
                //dd($doctor_id);

                $doctor = DB::table('hys_px_doctor')
                    ->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hys_px_doctor.hid')
                    ->leftJoin('hys_px_department', 'hys_px_department.id', '=', 'hys_px_doctor.department_id')
                    ->where('hys_px_doctor.id', '=', $doctor_id)
                    ->select('hys_px_hospital.name as hname',
                        'hys_px_department.name as dname',
                        'hys_px_doctor.name',
                        'hys_px_doctor.prof as title',
                        'hys_px_doctor.avatar',
                        'hys_px_doctor.intro',
                        'hys_px_doctor.shanchang as goodat',
                        'hys_px_doctor.schedule_time',
                        'hys_px_hospital.id as hid',
                        'hys_px_department.id as did',
                        'hys_px_doctor.id as doid')
                    ->first();
                //dd($doctor);

                if (! $doctor) {
                    $not_found_doctors_id_string .= ($not_found_doctors_id_string!='' ? ',' : '') . $doctor_id;
                    continue;
                }

                $candidate = Candidate::create([
                    'vote_id' => 5,
                    'no' => $no,
                    'name' => $doctor->name,
                    'desc' => $doctor->intro,
                    'pic_url' => $doctor->avatar,
                    'type' => 1,
                    'of_hos' => $doctor->hname,
                ]);
                $temp = [
                    'title' => $doctor->title,
                    'of_hos' => $doctor->hname,
                    'of_dep' => $doctor->dname,
                    'goodat' => $doctor->goodat,
                    'schedule_time' => $doctor->schedule_time,
                ];
                FieldValue::create([
                    'candidate_id' => $candidate->id,
                    'values' => serialize($temp),
                ]);
                $no++;
                $found_doctors_count++;

            }


            if ($not_found_doctors_id_string=='') {
                DB::commit();
            } else {
                DB::rollBack();
            }
            dd('此次共导入医生：'.$found_doctors_count.'名。数据库中未找到医生的id是：'.$not_found_doctors_id_string);


        });
    }

    public function getExport()
    {
        $retval = [];
        $candidate_list = Candidate::where('vote_id', '=', 5)->where('status', '<>', 3)->get();
        foreach ($candidate_list as $key => $item) {
            $extra_info = FieldValue::where('candidate_id', '=', $item->id)->first();
            if ($extra_info) {
                $extra_info = unserialize($extra_info->values);
            }

            $schedule_time_array = unserialize($extra_info['schedule_time']);
            $schedule_time_str = '';
            $week_map = [
                '1' => '星期一',
                '2' => '星期二',
                '3' => '星期三',
                '4' => '星期四',
                '5' => '星期五',
                '6' => '星期六',
                '7' => '星期日',
            ];
            $day_map = [
                '1' => '上午',
                '3' => '下午',
            ];
            if($schedule_time_array!==false){
                foreach ($schedule_time_array as $key => $value) {
                    if ($value=='1') {
                        $schedule_time_str .= $week_map[$key[0]].$day_map[$key[2]].($key+1==array_count_values($schedule_time_array)[1] ? '' : '，');
                    }
                }
                $extra_info['schedule_time'] = $schedule_time_str;
            }


            $temp = [
                '编号' => $item->no,
                '姓名' => $item->name,
                '医院' => $extra_info['of_hos'],
                '科室' => $extra_info['of_dep'],
                '职称' => $extra_info['title'],
                '类型' => $item->type==0 ? '西医' : ($item->type==1 ? '中医' : '评委'),
                '简介' => $item->desc,
                '擅长' => $extra_info['goodat'],
                '坐诊时间' => $extra_info['schedule_time'],
                '状态' => $item->status==0 ? '正常' : ($item->status==1 ? '待审核' : '锁定'),
                '票数' => $item->num,
            ];
            $retval[] = $temp;
        }
        $retval = collect($retval);

        Excel::create("儿科投票结果", function($excel) use($retval)
        {
            $excel->sheet('sheet1',function($sheet)  use($retval)
            {
                $sheet->fromModel($retval);
            });
        })->export('xls');
    }
}