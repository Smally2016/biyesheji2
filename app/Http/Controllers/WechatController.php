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
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function ($message) {
            return "欢迎关注 帅哥，请留下您的闺蜜联系方式！";
        });

        Log::info('return response.');
        return $wechat->server->serve();
    }
}
