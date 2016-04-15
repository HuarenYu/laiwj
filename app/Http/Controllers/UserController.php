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
        return response()->json(session('wechat.oauth_user'));
    }

    public function inn()
    {
        Auth::loginUsingId(1);
        $u = Auth::user();
        $user = User::find($u->id);
        $inn = $user->inns;
        return response()->json($inn);
    }

}
