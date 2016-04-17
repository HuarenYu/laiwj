<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth as Auth;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function weixinLogin()
    {
        $wechat = app('wechat');
        $response = $wechat->oauth->scopes(['snsapi_userinfo'])->redirect();
        return $response;
    }

    public function weixinLoginCallback(Request $request)
    {
        $wechat = app('wechat');
        $user = $wechat->oauth->user();
        $oldUser = User::where('openid', $user->getId())->first();
        $originalInfo = $user->getOriginal();
        //如果没有登陆过
        if (empty($oldUser)) {
            $newUser = new User;
            $newUser->openid = $originalInfo['openid'];
            $newUser->name = $originalInfo['nickname'];
            $newUser->headimgurl = $originalInfo['headimgurl'];
            $newUser->sex = $originalInfo['sex'];
            $newUser->province = $originalInfo['province'];
            $newUser->city = $originalInfo['city'];
            $newUser->country = $originalInfo['country'];
            $newUser->language = $originalInfo['language'];
            $newUser->privilege = json_encode($originalInfo['privilege']);
            $newUser->access_token = $user->token['access_token'];
            $newUser->save();
            $oldUser = $newUser;
        } else {
            //如果已经登陆过
            $oldUser->openid = $originalInfo['openid'];
            $oldUser->name = $originalInfo['nickname'];
            $oldUser->headimgurl = $originalInfo['headimgurl'];
            $oldUser->sex = $originalInfo['sex'];
            $oldUser->province = $originalInfo['province'];
            $oldUser->city = $originalInfo['city'];
            $oldUser->country = $originalInfo['country'];
            $oldUser->language = $originalInfo['language'];
            $oldUser->privilege = json_encode($originalInfo['privilege']);
            $oldUser->access_token = $user->token['access_token'];
            $oldUser->save();
        }
        Auth::login($oldUser);
        return redirect($request->session()->pull('redirect_url', '/'));
    }

}
