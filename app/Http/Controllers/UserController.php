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
        $formData['users'] = User::select(['id', 'first_name as firstname', 'last_name as lastname', 'username'])
                                ->orderBy('firstname')
                                ->paginate(5);

        $formData['viewUserStore'] = false;

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
            $User->role = $request->role;
            $User->username = $request->username;

            $User->save();

            return redirect()->route('user.list')->with(['userAddMessage' => true, 'message' => 'User added.']);
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

    public function update(Requests\UpdateUserRequest $request)
    {
        $user = User::find($request->id);

        $user->first_name = $request->firstname;
        $user->last_name = $request->lastname;
        $user->role = $request->role;
        $user->username = $request->username;

        $user->save();

        return redirect()->route('user.list')->with(['userListMessage' => true, 'message' => 'User updated.']);
    }

    public function get(Request $request)
    {
        $user = User::find($request->id);

        return Response::json(['success' => true, 'message' => 'User detail retrieved.', 'user' => $user]);
    }
}
