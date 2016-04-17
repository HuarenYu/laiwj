<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Inn;

class IndexController extends Controller
{

    public function index()
    {
        $inns = Inn::where('status', 'online')->with('host')->get();
        return view('index', ['inns' => $inns]);
    }

}
