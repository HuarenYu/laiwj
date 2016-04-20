<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Gate;
use App\Inn;

class AdminController extends Controller
{
    public function editInn($id)
    {
        $inn = Inn::findOrFail($id);
        if (Gate::denies('admin')) {
            abort(403);
        }
        return view('user.inn', ['inn' => $inn]);
    }

    public function addInn()
    {
        if (Gate::denies('admin')) {
            abort(403);
        }
        return view('user.inn');
    }
}
