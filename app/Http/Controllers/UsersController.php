<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{

    private $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Utils\BusinessException
     */
    public function index()
    {
        return $this->userService->all();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Utils\BusinessException
     */
    public function paginate(Request $request)
    {
        return $this->userService->paginate($request);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Utils\BusinessException
     */
    public function show(Request $request)
    {
        return $this->userService->findById($request);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Utils\BusinessException
     */
    public function create(Request $request)
    {
        return $this->userService->create($request);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Utils\BusinessException
     */
    public function update($id, Request $request)
    {
        return $this->userService->updateById($id, $request);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Utils\BusinessException
     */
    public function delete($id)
    {
        return $this->userService->deleteById($id);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Utils\BusinessException
     */
    public function updateAvatar(Request $request)
    {
        return $this->userService->updateAvatar($request);
    }
}
