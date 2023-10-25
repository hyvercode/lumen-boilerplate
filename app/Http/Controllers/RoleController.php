<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Utils\BusinessException
     */
    public function index()
    {
        return $this->roleService->all();
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function paginate(Request $request)
    {
        return $this->roleService->paginate($request);
    }
}
