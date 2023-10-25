<?php

namespace App\Utils;

use Exception;
use Throwable;

class BusinessException extends Exception
{
    /**
     * @var
     */
    public $message;
    protected $httpStatus;
    protected $code;
    /**
     * GeneralException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(int $httpStatus, $message = Constants::ERROR_MESSAGE_404, $code = Constants::HTTP_CODE_404,Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->httpStatus = $httpStatus;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            "code" => $this->code,
            "message" => $this->message,
            "time_stamp" => DateTimeConverter::getDateTimeNow()
        ]);
    }
}
