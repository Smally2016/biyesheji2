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

        $app = new Application(config('wechat'));
        $oauth = $app->oauth;
// 未登录

        $wechat_user = $_SESSION['wechat_user'];
        if (empty($_SESSION['wechat_user'])) {
            $_SESSION['target_url'] = '/';
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }

        return redirect('/');
    }
}
