<?php

namespace App\Utils;

/**
 * Class Constants
 * @package App\Utils
 */
class Constants
{
    const APP_NAME = "homestead";
    const IMAGE_FORMAT_PNG = "png";
    const SYSTEM = "System";
    const ACTIVE = true;
    const NON_ACTIVE = false;
    const ADMIN = 'admin';
    const USER = 'user';
    const ENCRYPT = 'encrypt';
    const DECRYPT = 'decrypt';
    const POST = 'POST';
    const GET = 'GET';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const ERROR = 'ERROR';
    const INFO = 'INFO';
    const WARNING = 'WARNING';
    const REQUEST = 'REQUEST';
    const RESPONSE = 'RESPONSE';

    //ERROR CODE
    const HTTP_CODE_200 = 200;
    const HTTP_CODE_404 = 404;
    const HTTP_CODE_500 = 500;
    const HTTP_CODE_409 = 409;
    const HTTP_CODE_401 = 401;
    const HTTP_CODE_403 = 403;
    const HTTP_CODE_422 = 422;

    const ERROR_CODE_90 = 90;
    const ERROR_CODE_91 = 91;
    const ERROR_CODE_902 = 92;

    //ERROR MESSAGE
    const HTTP_MESSAGE_200 = 'Success';
    const ERROR_MESSAGE_404 = 'Not Found';
    const ERROR_MESSAGE_401 = 'Unauthorized';
    const ERROR_MESSAGE_500 = 'Internal Server Error';
    const ERROR_MESSAGE_90 = 'Error Business Exception';
    const ERROR_MESSAGE_91 = 'Record Not Found';
    const ERROR_MESSAGE_95 = 'Error Http Request';
}
