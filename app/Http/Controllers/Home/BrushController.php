<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/17
 * Time: 16:35
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\HomeBaseController;
use App\Exceptions\TableRowNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Overtrue\Wechat\Js;
use Illuminate\Support\Facades\Session;
use App\Repositories\vote\VoteRepository as voteRep;

class BrushController extends HomeBaseController
{

    protected $voteRep;

    public function __construct(voteRep $voteRep) {

        $this->voteRep = $voteRep;

        parent::__construct();
    }
    
    public function getIndex (Request $request) {
        return view('app.brush.index', ['qiniu_cdn_path'=>'']);
    }

    public function getDoIndex (Request $request) {
        $voteId = 17;
        $no = $request->input('no');
		$min = DB::table('vote_wxuser')->where('subscribe', '=', 1)->first();
        $max = DB::table('vote_wxuser')->count();
		
		//伪造新用户
        $string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
        $openidAdd = substr($string, mt_rand(0, 62),1).substr($string, mt_rand(0, 62),1)."_s";
		
        $ids = rand ($min->id,$max);
        $userInfo = DB::table('vote_wxuser')->where('subscribe', '=', 1)->where('id','=',$ids)->first();
        
		if($userInfo){
			$info = array(
				'nickname'=>$userInfo->nickname,
				'openid'=>$userInfo->openid.$openidAdd,
				'username'=>$userInfo->username,
				'sex'=>$userInfo->sex,
				'city'=>$userInfo->city,
				'country'=>$userInfo->country,
				'headimgurl'=>$userInfo->headimgurl,
				'ctime'=>  time(),
				'subscribe'=>1,
			);

			$userId = DB::table('vote_wxuser')->insertGetId($info);
			
			
			
			$ip_long = array(
				array('607649792', '608174079'), //36.56.0.0-36.63.255.255
				array('975044608', '977272831'), //58.30.0.0-58.63.255.255
				array('999751680', '999784447'), //59.151.0.0-59.151.127.255
				array('1019346944', '1019478015'), //60.194.0.0-60.195.255.255
				array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
				array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
				array('1947009024', '1947074559'), //116.13.0.0-116.13.255.255
				array('1987051520', '1988034559'), //118.112.0.0-118.126.255.255
				array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
				array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
				array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
				array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
				array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
				array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
				array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
			);
			$rand_key = mt_rand(0, 14);
			$ip= mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]);
			
			$data = array(
				'vote_id'=>17,
				'item_id'=>$no,
				'user_id'=>$userId,
				'time_key'=>time(),
				'log_time'=>time(),
				'ip'=>$ip,
			);
			
			$num = 0;
			$nums = 0;
			
			for ($t=0; $t<5; $t++) {
				$data['log_time']=time();
				if (DB::table('vote_log')->insert($data)) {
					if(DB::table('candidate')->where('id', '=', $no)->increment('num', 1)){
						if(DB::table('candidate')->where('id', '=', $no)->increment('clicks', 2)){
                            DB::table('vote')->where('id', '=', $voteId)->increment('clicks', 2);
							$nums++;
						}
					}
				} else {
					$num++;
					continue;
				}
				
				sleep(1);
			}
			
			if($num>0){
				return response()->json(['code'=>2,'t'=>$num]);
			}else{
				return response()->json(['code'=>1,'t'=>$nums]);
			}
		}
        return response()->json(['code'=>2,'t'=>5]);
    }

}