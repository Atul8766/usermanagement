<?php

namespace App\Http\Controllers\Auth;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLogin;
use App\Http\Requests\AuthRegister;
use App\Http\Requests\BulkUserStoreRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Function: register
     * @param \App\Http\Requests\AuthRegister $request
     * @return \App\Helper\ApiResponse $response
     */
    public function register(AuthRegister $request)
    {
        try {
            $response = $this->authService->authRegister($request);
            if ($response) {
                return ApiResponse::success(status: self::SUCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $response, statusCode: self::SUCCESS_CODE);
            }
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::FAILED_MESSAGE, statusCode: self::ERROR_CODE);
        } catch (Exception $e) {
            Log::error("Expcection occoured while registering user" . $e->getMessage());
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR_CODE);
        }
    }

    /**
     * Function: login
     * @param \App\Http\Requests\AuthRegister $request
     * @return \App\Helper\ApiResponse $response
     */
    public function login(AuthLogin $request)
    {
        try {
            $loginResponse = $this->authService->userLogin($request);
            if (!$loginResponse) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::INVALID_CREDENTIALS, statusCode: self::ERROR_CODE);
            }
            return ApiResponse::success(status: self::SUCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $loginResponse, statusCode: self::SUCCESS_CODE);
        } catch (Exception $e) {
            Log::error("Expcection occoured while login user" . $e->getMessage());
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR_CODE);
        }
    }

    /**
     * Function: userProfile
     * @param NA
     * @return \App\Helper\ApiResponse $response
     */
    public function userProfile()
    {
        try {
            $authUser = $this->authService->userProfile();
            if (!$authUser) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::USER_NOT_FOUND, statusCode: self::ERROR_CODE);
            }
            return ApiResponse::success(status: self::SUCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $authUser, statusCode: self::SUCCESS_CODE);
        } catch (Exception $e) {
            Log::error("Expcection occoured while fetching user" . $e->getMessage());
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR_CODE);
        }
    }


    /**
     * Function: logout
     * @param NA
     * @return \App\Helper\ApiResponse $response
     */
    public function logout()
    {
        try {
            $response = $this->authService->userLogout();
            if (!$response) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::USER_NOT_FOUND, statusCode: self::ERROR_CODE);
            }
            return ApiResponse::success(status: self::SUCESS_STATUS, message: self::USER_LOGGED_OUT, statusCode: self::SUCCESS_CODE);
        } catch (Exception $e) {
            Log::error("Expcection occoured while logout the user" . $e->getMessage());
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR_CODE);
        }
    }


    /**
     * Function: logout
     * @param NA
     * @return \App\Helper\ApiResponse $response
     */
    public function usersList()
    {
        try {
            $response = $this->authService->userList();
            if (!$response) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::FAILED_MESSAGE, statusCode: self::ERROR_CODE);
            }
            return ApiResponse::success(status: self::SUCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $response, statusCode: self::SUCCESS_CODE);
        } catch (Exception $e) {
            Log::error("Expcection occoured while fetching usersList" . $e->getMessage());
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR_CODE);
        }
    }

    /**
     * Function: logout
     * @param Request $request
     * @return \App\Helper\ApiResponse $response
     */
    public function delete($id)
    {
        try {
            $response = $this->authService->userDelete($id);
            if (!$response) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::USER_NOT_FOUND, statusCode: self::NOT_FOUND);
            }
            return ApiResponse::success(status: self::SUCESS_STATUS, message: self::SUCCESS_MESSAGE,  statusCode: self::SUCCESS_CODE);
        } catch (Exception $e) {
            Log::error("Expcection occoured while deleting the user" . $e->getMessage());
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR_CODE);
        }
    }

    /**
     * Function: register
     * @param \App\Http\Requests\AuthRegister $request
     * @return \App\Helper\ApiResponse $response
     */
    public function createUsers(BulkUserStoreRequest $request)
    {
        try {
            $response = $this->authService->bulkRegister($request);
            if ($response) {
                return ApiResponse::success(status: self::SUCESS_STATUS, message: self::SUCCESS_MESSAGE, statusCode: self::SUCCESS_CODE);
            }
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::FAILED_MESSAGE, statusCode: self::ERROR_STATUS);
        } catch (Exception $e) {
            Log::error("Expcection occoured while registering user" . $e->getMessage());
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR_CODE);
        }
    }

    /**
     * Function: register
     * @param \App\Http\Requests\AuthRegister $request
     * @return \App\Helper\ApiResponse $response
     */
    public function updateUsers($id, UpdateUserRequest $request)
    {
        try {
            $response = $this->authService->userUpdate($request, $id);
            if ($response) {
                return ApiResponse::success(status: self::SUCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $response, statusCode: self::SUCCESS_CODE);
            }
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::FAILED_MESSAGE, statusCode: self::ERROR_STATUS);
        } catch (Exception $e) {
            Log::error("Expcection occoured while registering user" . $e->getMessage());
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR_CODE);
        }
    }
}
