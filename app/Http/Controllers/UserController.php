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
use App\FreeTry;
use Log;

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
        return view('user.tripDetail', ['trip' => $order]);
    }

    public function tripPay($id)
    {
        $order = Order::with('inn')->findOrFail($id);
        if (Gate::denies('view-order', $order)) {
            return response('permission denied', 401);
        }
        if ($order->status != 'created' || $order->status != 'pay_failed') {
            return view('user.tripPay', ['error' => '该订单状态下无法支付']);
        }
        $wechat = app('wechat');
        $payment = $wechat->payment;
        $js = $wechat->js;
        $user = Auth::user();
        //生成微信支付订单
        $total_fee = $order->total_price * 100;
        //管理员测试
        if ($user->id === '1') {
            $total_fee = 10;
        }
        $attributes = [
            'body'             => '来我家呗订单',
            'detail'           => '预定' . $order->inn->name,
            'out_trade_no'     => $order->out_trade_no,
            'total_fee'        => $total_fee,//微信的total_fee是按照分计算的
            'trade_type'       => 'JSAPI',
            'notify_url'       => 'http://laiwj.com/weixin/payNotify',
            'openid'           => $user->openid,
        ];
        $wxOrder = new WeixinOrder($attributes);
        $result = $payment->prepare($wxOrder);
        if ($result->return_code == 'SUCCESS' &&
            $result->result_code == 'SUCCESS') {
            Log::info('生成微信支付订单成功', ['user_id' => $user->id,
                'order_id' => $order->id,
                'result' => $result,
            ]);
            $prepayId = $result->prepay_id;
            $order->prepay_id = $prepayId;
            $order->save();
            //生成微信js sdk 参数
            $payConfig = $payment->configForPayment($order->prepay_id, false);
            //生成js sdk 配置
            $jsConfig = $js->config(['chooseWXPay'], false, false, false);
            return view('user.tripPay', ['payConfig' => $payConfig, 'jsConfig' => $jsConfig]);
        }
        Log::error('生成微信支付订单错误', ['user_id' => $user->id,
            'order_id' => $order->id,
            'result' => $result,
        ]);
        return view('user.tripPay', ['error' => '微信支付系统错误']);
    }

    public function freeTrip()
    {
        return view('user.freeTrip');
    }

    public function freeTripSignup(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:20',
            'phone' => 'required|max:20',
            'introduce' => 'required:max:255',
            'gender' => 'required:max:255',
            'career' => 'required',
            'age' => 'required',
            'from' => 'required',
            'exp_time' => 'required',
        ]);
        $freeTry = new FreeTry;
        $freeTry->user_id = Auth::user()->id;
        $freeTry->name = $request->name;
        $freeTry->phone = $request->phone;
        $freeTry->introduce = $request->introduce;
        $freeTry->career = $request->career;
        $freeTry->age = $request->age;
        $freeTry->from = $request->from;
        $freeTry->gender = $request->gender;
        $freeTry->exp_time = $request->exp_time;
        $freeTry->save();
        return response()->json($freeTry);
    }

    public function crowdfunding()
    {
        return view('user.crowdfunding');
    }

}
