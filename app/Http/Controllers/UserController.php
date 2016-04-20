<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use App\User;
use App\Order;

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
        return view('user.trip');
    }

    public function tripDetail($id)
    {
        $order = Order::with('inn')->findOrFail($id);
        if (Gate::denies('view-order', $order)) {
            return response('permission denied', 401);
        }
        return view('user.tripDetail', ['order' => $order]);
    }

}
