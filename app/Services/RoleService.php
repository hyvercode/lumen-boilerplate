<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Utils\BaseResponse;
use App\Utils\Constants;
use Illuminate\Http\Request;

class RoleService
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function all()
    {
        return BaseResponse::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $this->roleRepository->all(['id', 'name'])
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function paginate(Request $request)
    {
        return BaseResponse::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $this->roleRepository->paginate($request->searchBy, $request->searchParam, $request->limit, ['*'], 'page', $request->page),
            $request->auth['request_id']
        );
    }
}
