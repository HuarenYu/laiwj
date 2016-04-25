<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use App\User;
use App\Order;
use EasyWeChat\Payment\Order as WeixinOrder;


class UserController extends Controller
{
    
    public function home()
    {
        return view('user.home');
    }

    public function inn()
    {
        $u = Auth::user();
        $user = User::find($u->id);
        $inn = $user->inn;
        return view('user.inn', ['inn' => $inn]);
    }

    public function trip()
    {
        $user = Auth::user();
        $trips = $user->trips()->with('inn')->orderBy('id', 'desc')->get();
        return view('user.trip', ['trips' => $trips]);
    }

    public function tripDetail($id)
    {
        $order = Order::with('inn')->findOrFail($id);
        if (Gate::denies('view-order', $order)) {
            return response('permission denied', 401);
        }
        $wechat = app('wechat');
        $payment = $wechat->payment;
        $attributes = [
            'body'             => 'iPad mini 16G 白色',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => '1217752501201407033233368018',
            'total_fee'        => 5388,
            'notify_url'       => 'http://xxx.com/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            // ...
        ];
        $order = new WeixinOrder($attributes);
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
        }
        $config = $payment->configForJSSDKPayment($prepayId);
        return view('user.tripDetail', ['order' => $order, 'config' => $config]);
    }

}
