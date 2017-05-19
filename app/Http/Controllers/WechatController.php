<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Log;

class WechatController extends Controller
{
    /**
     * @return mixed
     */
    public function serve()
    {

        $config = [
            // ...
            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => '/',
            ],
            // ..
        ];
        $app = new Application($config);
        $oauth = $app->oauth;
// 未登录

        $wechat_user = session('wechat_user');
        if (empty($wechat_user)) {
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }

        return redirect('/');
    }

    public function test()
    {
        if(session('wechat_user')){
            dd(session('wechat_user'));
        }

    }
}
