<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//additional includes
use App\Repositories\UserRepository;
use Auth;
use Exception;
use Response;
use View;

class UserController extends Controller
{
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @param Request $request
     *
     * @return \views
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->route('user.list');
        }

        return back()->withErrors('Invalid login.');
    }

    /**
     * @param none
     *
     * @return \views
     */
    public function logout()
    {
        Auth::logout();

        return View::make('user/login');
    }


    /**
     * @param none
     *
     * @return \views
     */
    public function index()
    {
        $formData                  = [];
        $formData['users']         = $this->user->getAllUsers();
        $formData['viewUserStore'] = false;

        if (Auth::user()->role == 1) {
            $formData['viewUserStore'] = true;
        }

        return View::make('user.list', $formData);
    }

    /**
     * @param StoreUserRequest $request
     *
     * @return \views
     */
    public function store(Requests\StoreUserRequest $request)
    {
        try {
            $this->user->store($request);

            return redirect()->route('user.list')->with(['userAddMessage' => true, 'message' => 'User added.']);
        } catch (Excception $e) {
            return redirect()->route('user.list')->withErrors($e);
        }
    }

    /**
     * @param Request $request
     *
     * @return \views
     */
    public function destroy(Request $request)
    {
        try{
            $this->user->destroy($request->id);

            return Response::json(['success' => true, 'message' => 'User deleted.']);
        } catch(Exception $e) {
            return Response::json(['success' => false, 'message' => $e]);
        }
    }

    /**
     * @param UpdateUserRequest $request
     *
     * @return \views
     */
    public function update(Requests\UpdateUserRequest $request)
    {
        $this->user->update($request);

        return redirect()->route('user.list')->with(['userListMessage' => true, 'message' => 'User updated.']);
    }

    /**
     * @param Request $request
     *
     * @return \views
     */
    public function get(Request $request)
    {
        $user = $this->user->getUserById($request->id);

        return Response::json(['success' => true, 'message' => 'User detail retrieved.', 'user' => $user]);
    }
}
