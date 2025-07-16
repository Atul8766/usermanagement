<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Redis;

class AuthRepository
{
    /**
     * Create new class instance
     */
    public function __construct()
    {
        //
    }

    /**
     * Function: registerUser
     * @param $userRequest
     * @return $response
     */
    public function registerUser(array $userRequest)
    {
        return User::create($userRequest);
    }


    /**
     * Function: registerUser
     * @param $role, $userId
     * @return $response
     */
    public function usersList($role, $userId)
    {
        switch ($role) {
            case 'superadmin':
                $cachedUsers = Redis::get('users');

                if ($cachedUsers) {
                    return json_decode($cachedUsers, true);  // return cached result
                }

                // Fetch, cache and return
                $users = User::all();
                Redis::set('users', $users->toJson());
                return $users;

            case 'admin':
                return User::where('role', 'user')->get();

            case 'user':
                return User::where('id', $userId)->get();

            default:
                return collect();
        }
    }


    /**
     * Function: registerUser
     * @param $userId
     * @return $response
     */

    public function userDelete($userId)
    {
        return User::where('id', $userId)->delete();
    }

    public function userUpdate($role, $userUpdatedData, $userId)
    {
        switch ($role) {
            case 'superadmin':
                return User::where('id', $userId)->update($userUpdatedData);

            case 'admin':
                $targetUser = User::where('id', $userId)->first();
                if ($targetUser && ($targetUser->role === 'user' || auth()->id() === $userId)) {
                    return User::where('id', $userId)->update($userUpdatedData);
                }
                return false;

            case 'user':
                if (auth()->id() === $userId) {
                    return User::where('id', $userId)->update($userUpdatedData);
                }
                return false;

            default:
                return false;
        }
    }
}
