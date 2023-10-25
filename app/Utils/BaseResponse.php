<?php

namespace App\Utils;

use http\Client\Response;
use stdClass;
use DateTime;

/**
 * Class BaseResponse
 * @package App\Utils
 */
class BaseResponse
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public static function emptyResponse()
    {
        return response()->json(new stdClass());
    }


    /**
     * @param int $code
     * @param string $status
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function buildResponse(int $code = Constants::HTTP_CODE_404, string $status = Constants::ERROR_MESSAGE_404, $data = [], string $request_id = null)
    {
        return response()->json(array(
                'request_id' => $request_id,
                'code' => $code,
                'status' => $status,
                'data' => $data,
                'time_stamp' => DateTimeConverter::getDateTimeNow(),
                'time_ISO_8601' => DateTimeConverter::dateTimeFormatNow(DateTime::ISO8601))
        );
    }

    /**
     * @param int $code
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function statusResponse(int $code = Constants::HTTP_CODE_404, string $status = Constants::ERROR_MESSAGE_404, string $request_id = null)
    {
        return response()->json(array(
                'request_id' => $request_id,
                'code' => $code,
                'status' => $status,
                'time_stamp' => DateTimeConverter::getDateTimeNow(),
                'time_ISO_8601' => DateTimeConverter::dateTimeFormatNow(DateTime::ISO8601))
        );
    }

}
