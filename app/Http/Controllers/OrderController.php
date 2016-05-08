<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Inn;
use App\Order;
use Auth;
use DB;
use Gate;

use Carbon\Carbon;

class OrderController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response('permission denied', 401);
        }
        $this->validate($request, [
            'customer_name' => 'required|max:20',
            'customer_phone' => 'required|max:16',
            'customer_count' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'inn_id' => 'required|numeric',
        ]);
        $today = Carbon::today();
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        if ($startDate->lt($today)) {
            return response('入住日期不能是过去', 400);
        }
        if ($endDate->lte($startDate)) {
            return response('入住日期不能在离开日期之后', 400);
        }
        DB::beginTransaction();
        $inn = DB::table('inns')->where('id', '=', $request->inn_id)->lockForUpdate()->first();
        if (empty($inn)) {
            return response('客栈id错误', 401);
        }

        $innSchedule = json_decode($inn->schedule);
        foreach ($innSchedule as $bookDate) {
            $tmpDate = Carbon::parse($bookDate);
            if ($tmpDate->gte($startDate) && $tmpDate->lt($endDate)) {
                return response()->json(['statusCode' => 40001,
                    'msg' => '不能包含已经被预订的日期',
                    'inn' => $inn,
                ]);
            }
        }
        //预定的日期
        $bookDates = [];
        while ($startDate->lt($endDate)) {
            $bookDates[] = $startDate->toDateString();
            $startDate->addDay(1);
        }
        //增加schedule
        $newInnSchedule = array_merge($innSchedule, $bookDates);
        //更新schedule
        DB::table('inns')->where('id', '=', $request->inn_id)->update(['schedule' => json_encode($newInnSchedule)]);
        //生成订单
        $order = new Order;
        $order->customer_id = Auth::user()->id;
        $order->customer_name = $request->customer_name;
        $order->customer_phone = $request->customer_phone;
        $order->customer_count = $request->customer_count;
        $order->start_date = $request->start_date;
        $order->end_date = $request->end_date;
        $order->per_price = $inn->price;
        $order->total_price = $inn->price * intval($request->customer_count) * count($bookDates);
        $order->book_count = count($bookDates);
        $order->inn_id = $inn->id;
        $order->status = 'created';
        $order->save();
        $order->out_trade_no = Carbon::now()->format('YmdHis') . $order->id;
        $order->save();
        DB::commit();
        return response()->json($order);

    }
    
    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        if (Gate::denies('update-order', $order)) {
            return response('permission denied', 401);
        }
        if ($order->status == 'created') {
            DB::beginTransaction();
            $order->releaseBookedDays();
            $order->status = 'canceled';
            $order->save();
            DB::commit();
            return response()->json(['status' => 'success', 'msg' => '取消成功']);
        }
        return response()->json(['status' => 'fail', 'msg' => '取消失败']);
    }
}
