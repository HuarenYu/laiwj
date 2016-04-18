<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Inn;

use Carbon\Carbon;
use Mockery\Exception;

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
        $this->validate($request, [
            'customer_name' => 'required|max:20',
            'customer_phone' => 'required|max:16',
            'customer_count' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'inn_id' => 'required|numeric',
        ]);


        $inn = Inn::findOrFail($request->inn_id);
        if (empty($inn)) {
            return response('客栈id错误', 401);
        }
        $innSchedule = json_decode($inn->schedule);
        
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        //预定的日期
        $bookDates = [];
        while ($startDate->lte($endDate)) {
            $bookDates[] = Carbon::instance($startDate);
            $startDate->addDay(1);
        }

        return response()->json($bookDates);

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
