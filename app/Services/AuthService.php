<?php


namespace App\Services;

use App\Jobs\CreateUserJob;
use App\Repository\AuthRepository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $authRepository;
    /**
     * Create new class instance
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Function: authRegister
     * @param \App\Http\Requests\AuthRegister $request
     * @return $response
     */
    public function authRegister($request)
    {
        $validatedData = $request->validated();
        return $this->authRepository->registerUser($validatedData);
    }

    /**
     * Function: userLogin
     * @param \App\Http\Requests\AuthLogin $request
     * @return $response
     */
    public function userLogin($request)
    {
        $validatedData = $request->validated();
        if (!Auth::attempt($validatedData)) {
            return false;
        }
        $authUser = Auth::user();
        $token = $authUser->createToken('token')->accessToken;
        return [
            'email' => $authUser->email,
            'token' => $token
        ];
    }


    /**
     * Function: userProfile
     * @param NA
     * @return $user
     */
    public function userProfile()
    {
        return Auth::user();
    }

    /**
     * Function: userLogout
     * @param NA
     * @return boolean
     */

    public function userLogout()
    {
        $authUser = Auth::user();
        if ($authUser) {
            $authUser->token()->revoke();
            return true;
        }
        return false;
    }

    /**
     * Function: userList
     * @param NA
     * @return $response
     */

    public function userList()
    {
        $authUser = Auth::user();
        $role = $authUser->role;
        $id = $authUser->id;
        return $this->authRepository->usersList($role, $id);
    }

    public function userDelete($id)
    {
        if (!$id) {
            return false;
        }
        return $this->authRepository->userDelete($id);
    }

    public function bulkRegister($request)
    {
        $validatedData = $request->validated()['users'];
        dispatch(new CreateUserJob($validatedData, $this->authRepository));
        return true;
    }

    public function userUpdate($request, $id)
    {
        $validatedData = $request->validated();
        if (!empty($validatedData)) {
            $authUser = Auth::user();
            $role = $authUser->role;
            return $this->authRepository->userUpdate($role, $validatedData, $id);
        } else {
            return false;
        }
    }
}
