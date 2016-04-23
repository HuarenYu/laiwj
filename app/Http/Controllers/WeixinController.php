<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

use Log;

class WeixinController extends Controller
{

    public function message()
    {
        
        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function ($message) use ($wechat) {
            $reply = '欢迎关注来我家呗，在这里你拥有的不只是一次旅行，而是像走亲访友一样的去深度体验当地的风景，人文，美食，民风，民俗。立刻出发吧！';
            switch ($message->MsgType)
            {
            case 'event':
                # 事件消息...
                $oldUser = User::where('openid', $message->FromUserName)->first();
                if ($message->Event == 'subscribe') {
                    $userService = $wechat->user;
                    $user = $userService->get($message->FromUserName);
                    //如果第一次关注
                    if (empty($oldUser)) {
                        $newUser = new User;
                        $newUser->openid = $user->openid;
                        $newUser->name = $user->nickname;
                        $newUser->headimgurl = $user->headimgurl;
                        $newUser->sex = $user->sex;
                        $newUser->province = $user->province;
                        $newUser->city = $user->city;
                        $newUser->country = $user->country;
                        $newUser->language = $user->language;
                        $newUser->privilege = json_encode($user->privilege);
                        $newUser->subscribe = $user->subscribe;
                        $newUser->subscribe_time = $user->subscribe_time;
                        $newUser->groupid = $user->groupid;
                        $newUser->save();
                    } else {
                        //如果重新关注
                        $oldUser->name = $user->nickname;
                        $oldUser->headimgurl = $user->headimgurl;
                        $oldUser->sex = $user->sex;
                        $oldUser->province = $user->province;
                        $oldUser->city = $user->city;
                        $oldUser->country = $user->country;
                        $oldUser->language = $user->language;
                        $oldUser->privilege = json_encode($user->privilege);
                        $oldUser->subscribe = $user->subscribe;
                        $oldUser->subscribe_time = $user->subscribe_time;
                        $oldUser->groupid = $user->groupid;
                        $oldUser->save();
                    }
                }
                if ($message->Event == 'unsubscribe') {
                    $oldUser->subscribe = 0;
                    $oldUser->unsubscribe_time = time();
                    $oldUser->save();
                }
                break;
            case 'text':
                # 文字消息...
                //break;
            case 'image':
                # 图片消息...
                //break;
            case 'voice':
                # 语音消息...
                //break;
            case 'video':
                # 视频消息...
                //break;
            case 'location':
                # 坐标消息...
                //break;
            case 'link':
                # 链接消息...
                //break;
                // ... 其它消息
            default:
                # code...
                $reply = '你好！有问题请加微信：18514031568';
                break;
            }
            return $reply;

        });

        return $wechat->server->serve();
    }

    public function createMenu()
    {
        $wechat = app('wechat');
        $menu = $wechat->menu;
        $buttons = [
            [
                'type' => 'view',
                'name' => '出发',
                'url'  => 'http://laiwj.com'
            ],
            [
                'name'       => '我的',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '行程',
                        'url'  => 'http://laiwj.com/user/trip'
                    ],
                    [
                        'type' => 'view',
                        'name' => '家',
                        'url'  => 'http://laiwj.com/user/inn'
                    ],
                ],
            ],
        ];
        $menu->add($buttons);
        return response()->json($buttons);
    }

}
