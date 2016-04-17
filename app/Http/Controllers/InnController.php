<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Inn;
use Auth;

class InnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
            'name' => 'required|max:30',
            'hostName' => 'required|max:10',
            'hostPhone' => 'required|min:11|max:16',
            'price' => 'required|numeric',
            'image' => 'required',
            'detail' => 'required',
        ]);
        $inn = new Inn;
        $inn->name = $request->name;
        $inn->hostName = $request->hostName;
        $inn->hostPhone = $request->hostPhone;
        $inn->price = $request->price;
        $inn->images = json_encode([$request->image]);
        $inn->detail = $request->detail;
        $inn->description = '';
        $inn->country = '中国';
        $inn->province = '贵州';
        $inn->city = '黎平';
        $inn->owner_id = Auth::user()->id;
        $inn->status = 'pending';
        $inn->save();
        return response()->json($inn);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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

    public function detail($id)
    {
        $inn = Inn::with('host')->findOrFail($id);
        return view('inn.detail', ['inn' => $inn]);
    }

    public function order($id)
    {
        return view('inn.order', ['id' => $id]);
    }
}
