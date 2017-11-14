<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//additional includes
use Auth;
use View;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->route('user.list');
        }

        return back()->withErrors('Invalid login');
    }


    public function index()
    {
        return View::make('user.list');
    }
}
