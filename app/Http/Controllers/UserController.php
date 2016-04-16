<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

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
        $inn = $user->inns;

        return view('user.inn', ['inn' => $inn]);
    }

    public function trip()
    {
        return view('user.trip');
    }

}
