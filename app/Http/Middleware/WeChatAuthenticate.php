<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Extensions\Common;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\TableRowNotFoundException;
use Overtrue\Wechat\Auth as WechatAuth;
use Illuminate\Support\Facades\DB;
use Overtrue\Wechat\User;

class WeChatAuthenticate
{
    use Common;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null, $voteId = null)
    {
        if (! $this->isPositiveInteger($voteId)) {
            throw new InvalidArgumentException('投票id必须是正整数');
        }

        // debug level.may be removed.
        $type = $request->input('type');
        $code = $request->input('code');
        if ($code) {
            $http = url()->current();
            if ($type) {
                header("Location:{$http}?id={$voteId}&type={$type}");
            } else {
                header("Location:{$http}?id={$voteId}");
            }
        }
        
        $vote = DB::table('vote')->where('id', '=', $voteId)->first();
        if (! $vote) {
            throw new \Exception('没有该投票');
        }

        // because our system supports multiple votes,
        // we have to add suffix to verify different openids.
        $openid = Session::get('openid_'.$voteId, '');

        // for now our system don't deal with login-vote(if you want to login, you have to login first).
        // the following code intends to get openid.
        // by default, the openid will be persisted for 120 mins.
        if (empty($openid)) {
            $wechatAuth = new WechatAuth($vote->appid, $vote->appsecret);
            if (empty($_GET['code'])) {
                $wechatAuth->redirect(url()->full(), 'snsapi_base');
            } else {
                $permission = $wechatAuth->getAccessPermission($_GET['code']);
                $openid = $permission['openid'];
                Session::put('openid_'.$voteId, $openid);
            }
        }

        // the following code intends to get wechat userinfo.
        // by default, access_token will be cached for (7200-800-500)s
        $wechatUser = new User($vote->appid, $vote->appsecret);
        $userInfo = $wechatUser->get($openid)->all();

        // save the subscribe info into session for view to check
        // if the wxuser has subscribed.
        Session::put('subscribe_'.$voteId, $userInfo['subscribe']);

        Session::put('userInfo_'.$voteId, $userInfo);

        // save it.
        $this->saveWxUserInfo($userInfo, $voteId);


        return $next($request);
    }

    private function saveWxUserInfo ($userInfo, $voteId) {
        // only the subscribed wxuser will be inserted or updated.
        if ($userInfo['subscribe']==1) {
            $subUser = DB::table('vote_wxuser')->where('openid', '=', $userInfo['openid'])->first();
            if (empty($subUser)) {
                $insertData = [
                    'openid'     => $userInfo['openid'],
                    'subscribe'  => $userInfo['subscribe'],
                    'nickname'   => $userInfo['nickname'],
                    'sex'        => $userInfo['sex'],
                    'province'   => $userInfo['province'],
                    'city'       => $userInfo['city'],
                    'country'    => $userInfo['country'],
                    'headimgurl' => $userInfo['headimgurl'],
                    'ctime'      => $userInfo['subscribe_time'],
                ];
                $insertId = DB::table('vote_wxuser')->insertGetId($insertData);
                // save the wxuserid into session.
                Session::put('wxuserid_'.$voteId, $insertId);
            } else {
                $updateData = [
                    'nickname'   => $userInfo['nickname'],
                    'sex'        => $userInfo['sex'],
                    'province'   => $userInfo['province'],
                    'city'       => $userInfo['city'],
                    'country'    => $userInfo['country'],
                    'headimgurl' => $userInfo['headimgurl'],
                    'subscribe'  => $userInfo['subscribe'],
                ];
                DB::table('vote_wxuser')->where('openid', '=', $userInfo['openid'])->update($updateData);
                // save the wxuserid into session.
                Session::put('wxuserid_'.$voteId, $subUser->id);
            }
        } else {
            $subUser = DB::table('vote_wxuser')->where('openid', '=', $userInfo['openid'])->first();
            if (empty($subUser)) {
                $insertData = [
                    'openid'     => $userInfo['openid'],
                    'subscribe'  => $userInfo['subscribe'],
                ];
                $insertId = DB::table('vote_wxuser')->insertGetId($insertData);
                // save the wxuserid into session.
                Session::put('wxuserid_'.$voteId, $insertId);
            } else {
                Session::put('wxuserid_'.$voteId, $subUser->id);
            }
        }
    }



}
