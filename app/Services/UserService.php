<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Utils\BaseResponse;
use App\Utils\BusinessException;
use App\Utils\CommonUtil;
use App\Utils\Constants;
use App\Utils\DateTimeConverter;
use App\Utils\ImageConverter;
use App\Utils\Monologger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService implements BaseService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function findById(Request $request)
    {
        $user = $this->userRepository->getById($request->id, ['users.id', 'users.name', 'users.email', 'users.employee_id', 'users.branch_id']);
        if (!$user) {
            throw new BusinessException(Constants::HTTP_CODE_401, Constants::ERROR_MESSAGE_401, Constants::ERROR_CODE_9001, $request->auth['request_id']);
        }

        return BaseResponse::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $user,
            $request->auth['request_id']
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function all()
    {
        return BaseResponse::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $this->userRepository->all(['users.id', 'users.username', 'users.name', 'users.phone_number', 'users.email', 'users.api_roles', 'users.menu_roles', 'users.company_id', 'users.branch_id', 'users.employee_id', 'users.status', 'users.coordinate'], 'status', Constants::ACTIVE)
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws BusinessException
     */
    public function create(Request $request)
    {
        try {
            $user = new User();
            $user->id = $request->employee_id;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->phone_number = CommonUtil::phoneNumber($request->phone_number);
            $user->email = $request->email;
            $user->api_roles = $request->api_roles;
            $user->enu_roles = $request->enu_roles;
            $user->branch_id = $request->branch_id;
            $user->company_id = $request->company_id;
            $user->employee_id = $request->employee_id;
            $user->coordinate = $request->coordinate;
            $user->status = strtoupper($request->status);
            $user->avatar = ImageConverter::base64ToImage('images/avatar', $request->avatar);
            $user->created_at = DateTimeConverter::getDateTimeNow();
            $user->created_by = $request->get('auth')['user_id'];
            $this->userRepository->create($user->toArray());
        } catch (\Exception $ex) {
            Monologger::log(Constants::ERROR, $ex->getMessage(), $request->get('auth')['request_id']);
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9000, Constants::ERROR_CODE_9000, $request->auth['request_id']);
        }

        return BaseResponse::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $request->auth['request_id']
        );
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws BusinessException
     */
    public function deleteById($id)
    {
        $record = $this->userRepository->getById($id);
        if (empty($record)) {
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9001, Constants::ERROR_CODE_9001);
        }
        try {
            $record->delete();
        } catch (\Exception $ex) {
            Monologger::log(Constants::ERROR, $ex->getMessage());
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9001, Constants::ERROR_CODE_9001);
        }

        return BaseResponse::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200
        );
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws BusinessException
     */
    public function getById($id)
    {
        $record = $this->userRepository->getById($id, ['users.id', 'users.username', 'users.name', 'users.phone_number', 'users.email', 'users.api_roles', 'users.menu_roles', 'users.company_id', 'users.branch_id', 'users.employee_id', 'users.status', 'users.coordinate']);
        if (empty($record)) {
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9001, Constants::ERROR_CODE_9001);
        }

        return BaseResponse::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $record
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
            $this->userRepository->paginate($request->searchBy, $request->searchParam, $request->limit, ['users.id', 'users.username', 'users.name', 'users.phone_number', 'users.email', 'users.api_roles', 'users.menu_roles', 'users.company_id', 'users.branch_id', 'users.employee_id', 'users.status', 'users.coordinate'], 'page', $request->page, 'status', Constants::ACTIVE),
            $request->auth['request_id']
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws BusinessException
     */
    public function updateById($id, Request $request)
    {
        $user = $this->userRepository->getById($id);
        if (empty($user)) {
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9001, Constants::ERROR_CODE_9001, $request->auth['request_id']);
        }
        try {
            $user->phone_number = CommonUtil::phoneNumber($request->phone_number);
            $user->email = $request->email;
            $user->api_roles = $request->api_roles;
            $user->enu_roles = $request->enu_roles;
            $user->branch_id = $request->branch_id;
            $user->coordinate = $request->coordinate;
            $user->status = strtoupper($request->status);
            $user->avatar = ImageConverter::base64ToImage('images/avatar', $request->avatar);
            $user->updated_at = DateTimeConverter::getDateTimeNow();
            $user->updated_by = $request->get('auth')['user_id'];
            $this->userRepository->updateById($id, $user->toArray());
        } catch (\Exception $ex) {
            Monologger::log(Constants::ERROR, $ex->getMessage(), $request->get('auth')['request_id']);
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9001, Constants::ERROR_CODE_9001, $request->auth['request_id']);
        }

        return BaseResponse::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $request->auth['request_id']
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws BusinessException
     */
    public function updateAvatar(Request $request)
    {
        $user = $this->userRepository->getById($request->get('auth')['user_id']);
        if (empty($user)) {
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9001, Constants::ERROR_CODE_9001, $request->auth['request_id']);
        }
        try {
            $user->avatar = ImageConverter::base64ToImage('images/avatar', $request->avatar);
            $user->updated_at = DateTimeConverter::getDateTimeNow();
            $user->updated_by = $request->get('auth')['user_id'];
            $this->userRepository->updateById($request->get('auth')['user_id'], $user->toArray());
        } catch (\Exception $ex) {
            Monologger::log(Constants::ERROR, $ex->getMessage(), $request->get('auth')['request_id']);
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9001, Constants::ERROR_CODE_9001, $request->auth['request_id']);
        }

        return BaseResponse::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $request->auth['request_id']
        );
    }
}
