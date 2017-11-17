<?php

namespace App\Repositories;


//additional includes
use App\User;
use Hash;

class UserRepository {

    /**
     * Soft deletes a user by id.
     *
     * @param int $id
     *
     * @return boolean
     */
    public function destroy($id)
    {
        return User::destroy($id);
    }

    /**
     * Retrieves all users.
     *
     *
     * @return mixed
     */
    public function getAllUsers()
    {
        return User::select(['id', 'first_name as firstname', 'last_name as lastname', 'username'])
                     ->orderBy('firstname')
                     ->paginate(5);
    }

    /**
     * Gets user detail by id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getUserById($id)
    {
        return User::find($id);
    }

    /**
     * Updates user by id.
     *
     * @param Request $request
     *
     * @return boolean
     */
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

    /**
     * Stores new user.
     *
     * @param Request $request
     *
     * @return boolean
     */
    public function store($request)
    {
        $user             = new User;
        $user->first_name = $request->firstname;
        $user->last_name  = $request->lastname;
        $user->password   = Hash::make($request->password);
        $user->role       = $request->role;
        $user->username   = $request->username;

        $user->save();

        return true;
    }
}