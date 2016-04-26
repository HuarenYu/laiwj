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
            $reply = '你好，欢迎关注“来我家呗！”

来一次走亲访友的旅行，同吃、同住、同劳动，深度体验当地特色文化生活！


欢迎参加“五一”期间3天免费体验活动！
“<a href="http://laiwj.com/user/freeTrip">点击立即报名申请</a>”';
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
                'name' => '入住',
                'url'  => 'http://laiwj.com'
            ],
            [
                'type' => 'view',
                'name' => '加盟',
                'url'  => 'http://laiwj.com/user/inn'
            ],
            [
                'type' => 'view',
                'name' => '众筹',
                'url'  => 'http://laiwj.com/user/crowdfunding'
            ],
        ];
        $menu->add($buttons);
        return response()->json($buttons);
    }

    public function payNotify()
    {
        $wechat = app('wechat');

        $response = $wechat->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = 查询订单($notify->transaction_id);

            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->paid_at) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }

            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                $order->paid_at = time(); // 更新支付时间为当前时间
                $order->status = 'paid';
            } else { // 用户支付失败
                $order->status = 'paid_fail';
            }

            $order->save(); // 保存订单

            return true; // 返回处理完成
        });

        return $response;

    }

}
