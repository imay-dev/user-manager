<?php

namespace App\Services\Auth;


use App\Models\User;
use \Laravel\Passport\Client;
use Illuminate\Http\Request;
use Laravel\Passport\PersonalAccessTokenResult;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    /**
     * @var User
     */
    protected $user;

    /**
     * AuthService constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $credentials
     *
     * @return bool
     */
    public function authenticate($user, $password)
    {
        return app('hash')->check($password, $user->password);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function register(Request $request)
    {
        return $this->user->create(
            $request->only('name', 'email', 'password')
        );
    }

    /**
     * @param $credentials
     *
     * @return PersonalAccessTokenResult
     */
    public function generateAccessToken($credentials)
    {
        $client = Client::where('provider', config('auth.guards.api.provider'))
            ->where('password_client', 1)->firstOrFail();
        $request = [
            'username' => $credentials['email'],
            'password' => $credentials['password'],
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => '*'
        ];
        $tokenRequest = Request::create(
            env('APP_URL').'/oauth/token',
            'post',
            $request
        );
        return json_decode(app()->dispatch($tokenRequest)->getContent(), true);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function logout(Request $request)
    {
        return $request->user()->token()->revoke();
    }

}
