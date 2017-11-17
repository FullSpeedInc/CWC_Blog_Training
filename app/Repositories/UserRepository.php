<?php

namespace App\Repositories;


//additional includes
use App\User;
use Hash;

class UserRepository {

    public function destroy($id)
    {
        return User::destroy($id);
    }

    public function getAllUsers()
    {
        return User::select(['id', 'first_name as firstname', 'last_name as lastname', 'username'])
                     ->orderBy('firstname')
                     ->paginate(5);
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function update($request)
    {
        $user             = User::find($request->id);
        $user->first_name = $request->firstname;
        $user->last_name  = $request->lastname;
        $user->role       = $request->role;
        $user->username   = $request->username;

        $user->save();

        return true;
    }

    public function store($request)
    {
        $User             = new User;
        $User->first_name = $request->firstname;
        $User->last_name  = $request->lastname;
        $User->password   = Hash::make($request->password);
        $User->role       = $request->role;
        $User->username   = $request->username;

        $User->save();

        return true;
    }
}