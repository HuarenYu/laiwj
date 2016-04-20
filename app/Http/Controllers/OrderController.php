<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Inn;
use App\Order;
use Auth;
use DB;

use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
        $tomorrow = Carbon::tomorrow();
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        if ($startDate->lt($tomorrow)) {
            return response('入住日期必须从明天开始', 401);
        }
        if ($endDate->lte($startDate)) {
            return response('入住日期必须在离开日期之前', 401);
        }
        DB::beginTransaction();
        $inn = DB::table('inns')->where('id', '=', $request->inn_id)->lockForUpdate()->first();
        if (empty($inn)) {
            return response('客栈id错误', 401);
        }

        $innSchedule = json_decode($inn->schedule);
        foreach ($innSchedule as $bookDate) {
            $tmpDate = Carbon::parse($bookDate);
            if ($tmpDate->gte($startDate) && $tmpDate->lte($endDate)) {
                return response('不能包含已经被预订的日期', 401);
            }
        }
        //预定的日期
        $bookDates = [];
        while ($startDate->lte($endDate)) {
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
        $order->inn_id = $inn->id;
        $order->save();
        DB::commit();
        return response()->json($order);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
