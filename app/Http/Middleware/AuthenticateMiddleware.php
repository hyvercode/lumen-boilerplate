<?php

namespace App\Http\Middleware;

use App\Utils\CommonUtil;
use App\Utils\Constants;
use Closure;

class AuthenticateMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws BusinessException
     */
    public function handle($request, Closure $next)
    {
        $allowedSecrets = explode(',', env('ALLOWED_SECRETS'));
        if (in_array($request->header('x-api-key'), $allowedSecrets)) {
            $request->request->add(
                ['auth' =>
                    [
                        'request_id' => CommonUtil::generateUUID(),
                        'user_id' => ''
                    ]
                ]);
            return $next($request);
        }
        return response()->json(['code' => Constants::HTTP_CODE_403, 'message' => ' Invalid API-KEY'], 403);
    }
}
