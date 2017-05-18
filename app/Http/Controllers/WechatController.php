<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        if (empty($_SESSION['wechat_user'])) {
            $_SESSION['target_url'] = '/';
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }

        return ;
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function ($message) {
            return "欢迎关注 帅哥，请留下您的闺蜜联系方式！";
        });

        Log::info('return response.');
        return $wechat->server->serve();
    }
}
