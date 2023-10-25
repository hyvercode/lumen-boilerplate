<?php

namespace App\Http\Middleware;

use App\Utils\BusinessException;
use App\Utils\CommonUtil;
use App\Utils\Constants;
use Closure;
use Illuminate\Http\Request;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws BusinessException
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $credentials = JWTAuth::parseToken()->authenticate();
            if ($credentials->status != Constants::ACTIVE) {
                throw new BusinessException(Constants::HTTP_CODE_403, 'Invalid Authorization', Constants::HTTP_CODE_403);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                throw new BusinessException(Constants::HTTP_CODE_401, 'Token is Invalid', Constants::HTTP_CODE_401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                throw new BusinessException(Constants::HTTP_CODE_403, 'Token is Expired', Constants::HTTP_CODE_403);
            } else {
                throw new BusinessException(Constants::HTTP_CODE_401, 'Authorization Token not found', Constants::HTTP_CODE_401);
            }
        }

        $request->request->add(
            ['auth' =>
                [
                    'request_id' => CommonUtil::generateUUID(),
                    'user_id' => $credentials->id,
                    'company_id' => $credentials->company_id,
                    'branch_id' => $credentials->branch_id,
                    'employee_id' => $credentials->employee_id,
                    'scope' => $credentials->scope,
                    'roles' => $credentials->roles,
                    'api_roles' => $credentials->api_roles
                ]
            ]);

        return $next($request);
    }
}
