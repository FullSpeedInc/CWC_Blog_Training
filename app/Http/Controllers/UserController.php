<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//additional includes
use App\User;
use Auth;
use Exception;
use Hash;
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
        $form_data = array();

        if (Auth::user()->role == 1) {
            $form_data['viewUserStore'] = true;
        }

        return View::make('user.list', $form_data);
    }



    public function store(Requests\StoreUserRequest $request)
    {
        try {
            $User = new User;

            $User->first_name = $request->firstname;
            $User->last_name = $request->lastname;
            $User->password = Hash::make($request->password);
            $User->username = $request->username;
            $User->role = $request->role;

            $User->save();

            return redirect()->route('user.list')->with(['message' => 'User added.']);
        } catch ( Excception $e) {
            return redirect()->route('user.list')->withErrors($e);
        }
    }
}
