<?php

namespace App\Utils;

/**
 * Class Constants
 * @package App\Utils
 */
class Constants
{
    const FCM_KEY = "key=AAAAkGaY0cY:APA91bFF0fvzzhkpo_jJw5i8mLtBdvUdICMoGGRUp4RIwYpKDcOIehJt7V4dVW9Ll8P58FCyynZ5376mljSD9fz5J2fYAb4hiNMav5VSmz9pNhwdt";
    const APP_NAME = "homestead";
    const IMAGE_FORMAT_PNG = "png";
    const SYSTEM = "System";
    const ACTIVE = "ACTIVE";
    const NON_ACTIVE = "NON ACTIVE";
    const ADMIN = 'admin';
    const USER = 'user';
    const PICKER = 'picker';
    const BOSS = 'boss';
    const PARTNER = 'partner';
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

    const ERROR_CODE_9000 = 9000;
    const ERROR_CODE_9001 = 9001;
    const ERROR_CODE_9002 = 9002;
    const ERROR_CODE_9003 = 9003;
    const ERROR_CODE_9004 = 9004;
    const ERROR_CODE_9005 = 9005;

    //ERROR MESSAGE
    const HTTP_MESSAGE_200 = 'Success';
    const ERROR_MESSAGE_404 = 'Not Found';
    const ERROR_MESSAGE_401 = 'Unauthorized';
    const ERROR_MESSAGE_500 = 'Internal Server Error';
    const ERROR_MESSAGE_9000 = 'Error Business Exception';
    const ERROR_MESSAGE_9001 = 'Record Not Found';
    const ERROR_MESSAGE_9002 = 'Account Not Found';
    const ERROR_MESSAGE_9003 = 'Your account inactive';
    const ERROR_MESSAGE_9004 = "Invalid OTP code";
    const ERROR_MESSAGE_9005 = 'Error Http Request';
}
