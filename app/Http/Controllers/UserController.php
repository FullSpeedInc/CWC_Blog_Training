<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//additional includes
use App\User;
use Auth;
use Exception;
use Hash;
use Response;
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
        $formData = array();
        $formData['users'] = User::all(['id', 'first_name as firstname', 'last_name as lastname', 'username']);

        if (Auth::user()->role == 1) {
            $formData['viewUserStore'] = true;
        }

        return View::make('user.list', $formData);
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
        } catch (Excception $e) {
            return redirect()->route('user.list')->withErrors($e);
        }
    }

    public function destroy(Request $request)
    {
        try{
            User::destroy($request->id);

            return Response::json(['success' => true, 'message' => 'User deleted.']);
        } catch(Exception $e) {
            return Response::json(['success' => false, 'message' => $e]);
        }
    }
}
