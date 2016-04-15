<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log;

class WeixinController extends Controller
{

    public function message()
    {
        Log::info('request arrived.'); 
        
        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function ($message) {
            return '立刻体验着独一无二的旅行吧！';
            /*
            switch ($message->MsgType)
            {
            case 'event':
                # 事件消息...
                break;
            case 'text':
                # 文字消息...
                break;
            case 'image':
                # 图片消息...
                break;
            case 'voice':
                # 语音消息...
                break;
            case 'video':
                # 视频消息...
                break;
            case 'location':
                # 坐标消息...
                break;
            case 'link':
                # 链接消息...
                break;
                // ... 其它消息
            default:
                # code...
                break;
            }
            */

        });

        Log::info('return response.');

        return $wechat->server->serve();
    }

}
