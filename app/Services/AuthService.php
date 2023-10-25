<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Utils\BaseResponse;
use App\Utils\BusinessException;
use App\Utils\CommonUtil;
use App\Utils\Constants;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthService
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone_number' => 'required|min:6|unique:users',
        ]);
        if ($validate->fails()) {
            throw new BusinessException(Constants::HTTP_CODE_422, $validate->errors(), Constants::ERROR_CODE_90);
        }

        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $request->password);
        $lowercase = preg_match('@[a-z]@', $request->password);
        $number = preg_match('@[0-9]@', $request->password);
        $specialChars = preg_match('@[^\w]@', $request->password);
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($request->password) < 6) {
            throw new BusinessException(Constants::HTTP_CODE_409, 'Password should be at least 6 characters in length and should include at least one upper case letter, one number, and one special character.', Constants::ERROR_CODE_90);
        }

        //Create new user
        try {
            $user = new User;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->status = Constants::ACTIVE;
            $user->phone_number = CommonUtil::phoneNumber($request->phone_number);
            $this->userRepository->create($user->toArray());
        } catch (\Exception $ex) {
            throw new BusinessException(Constants::HTTP_CODE_409, $ex->getMessage(), Constants::ERROR_CODE_90);
        }

        return BaseResponse::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout(true);

        return BaseResponse::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
        );
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return BaseResponse::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $this->respondWithToken(auth()->refresh())
        );
    }

    /**
     * @param $token
     * @param $username
     * @return array
     * @throws BusinessException
     */
    function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL($token)
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function login(Request $request)
    {
        $credentials = new User();
        $credentials->username = $request->username;
        $credentials->password = $request->password;
        $credentials->api_roles = Constants::ADMIN;
        $credentials->status = Constants::ACTIVE;

        $ttl = env('JWT_TTL', 1440);
        if ($request->remember_me) {
            $ttl = env('JWT_REMEMBER_TTL', 1051200);
        }

        if (!$token = auth()->setTTL($ttl)->attempt($credentials->toArray())) {
            throw new BusinessException(Constants::HTTP_CODE_409, 'Invalid username or password', Constants::ERROR_CODE_91);
        }

        return BaseResponse::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $this->respondWithToken($token)
        );
    }
}
