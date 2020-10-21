<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\MainController;
use App\Http\Requests\Auth\{Login, Register};
use App\Http\Resources\Auth\User;
use App\Models\User as UserEntity;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends MainController
{

    /**
     * @param Login $request
     * @param AuthService $authService
     *
     * @return JsonResponse
     */
    public function login(Login $request, AuthService $authService)
    {
        $credentials = $request->only('email', 'password');

        $user = UserEntity::where('email', $credentials['email'])->firstOrFail();
        if (!$authService->authenticate($user, $credentials['password'])) {
            return $this->response->fail([
                'errors' => [
                    'failed' => 'Not Authenticated',
                ],
            ]);
        }

        $token = $authService->generateAccessToken($credentials);
        return $this->response->success([
            'accessToken' => $token['access_token'],
            'expiresIn' => $token['expires_in'],
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function profile(Request $request)
    {
        return $this->response->success(new User($request->user()));
    }

    /**
     * @param Register $request
     * @param AuthService $authService
     *
     * @return JsonResponse
     */
    public function register(Register $request, AuthService $authService)
    {
        $user = $authService->register($request);

        return $this->response->success((new User($user)));
    }

    /**
     * @param Request $request
     * @param AuthService $authService
     *
     * @return JsonResponse
     */
    public function logout(Request $request, AuthService $authService)
    {
        $authService->logout($request);

        return $this->response->success();
    }

}
