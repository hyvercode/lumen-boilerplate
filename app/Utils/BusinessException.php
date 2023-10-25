<?php

namespace App\Utils;

use Exception;
use Throwable;
use Illuminate\Support\Facades\Log;

class BusinessException extends Exception
{
    /**
     * @var
     */
    public $message;
    protected $httpStatus;
    protected $code;
    /**
     * @var string|null
     */
    private $request_id;

    /**
     * GeneralException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(int $httpStatus, $message = Constants::ERROR_MESSAGE_404, $code = Constants::HTTP_CODE_404, string $request_id = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->httpStatus = $httpStatus;
        $this->code = $code;
        $this->message = $message;
        $this->request_id = $request_id;
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
        Monologger::log(Constants::ERROR, $this->message, $this->request_id);

        return response()->json([
            "request_id" => $this->request_id,
            "code" => $this->code,
            "message" => $this->message,
            "time_stamp" => DateTimeConverter::getDateTimeNow()
        ]);
    }
}
