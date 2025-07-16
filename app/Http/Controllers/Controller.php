<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    #MESSAGES
    public const SUCCESS_MESSAGE = 'Request Processed Successfully';
    public const FAILED_MESSAGE = 'Unable to process the request. Please try again';
    public const EXCEPTION_MESSAGE = 'Exception occured, Please try again';
    public const INVALID_CREDENTIALS = 'Unable to process the Login request.due to  Invalid credentials';
    public const USER_NOT_FOUND = 'User request not found';
    public const USER_LOGGED_OUT = 'User Logged out successfully';

    #STATUS KEYWORD
    public const SUCESS_STATUS = 'sucess';
    public const ERROR_STATUS = 'error';

    #STATUS CODE
    public const SUCCESS_CODE = 200;
    public const ERROR_CODE = 500;
    public const VALIDATION_ERROR = 422;
    public const NOT_FOUND = 404;
}
