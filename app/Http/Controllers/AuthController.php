<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Utils\BusinessException;
use Illuminate\Http\Request;

class AuthController extends Controller
{


    private $authService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function register(Request $request)
    {
        return $this->authService->register($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        return $this->authService->logout();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->authService->refresh();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function loginPicker(Request $request)
    {
        return $this->authService->loginPicker($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function loginBoss(Request $request)
    {
        return $this->authService->loginBoss($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function loginPartner(Request $request)
    {
        return $this->authService->loginPartner($request);
    }

}
