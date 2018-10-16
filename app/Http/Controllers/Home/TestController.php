<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/26
 * Time: 11:19
 */
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function getIndex (Request $request) {
        $vote_id = $request->input('vote_id');

        $output = [];
        $candidate_list = DB::table('candidate')->where('vote_id', '=', $vote_id)->get();
        foreach ($candidate_list as $key => $candidate_item) {
            $temp = [
                '编号'   => $candidate_item->id,
                '姓名'   => $candidate_item->name,
                '医院'   => $candidate_item->hos,
                '投票数' => $candidate_item->num,
            ];
            $output[] = $temp;
        }
        $output = collect($output);

        Excel::create("导出信息", function($excel) use($output)
        {
            $excel->sheet('sheet1',function($sheet)  use($output)
            {
                $sheet->fromModel($output);
            });
        })->export('xls');
    }

	public function mb_unserialize($str) {
		$out = preg_replace_callback('#s:(\d+):"(.*?)";#s',function($match){return 's:'.strlen($match[2]).':"'.$match[2].'";';},$str);
		return unserialize($out);
	}
}