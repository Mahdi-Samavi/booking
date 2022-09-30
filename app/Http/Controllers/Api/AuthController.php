<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'device_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $user = User::create($request->only('name', 'email', 'password'));
        $token = TokenController::createToken($user, $request->device_name);

        return $this->validResponse([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'roles' => ['user'],
            'expires_in' => $token->accessToken->expires_at,
        ]);
    }

    public function login(AuthRequest $request)
    {
        $this->check($request);

        $user = Auth::user();
        $token = TokenController::createToken($user, $request->device_name);

        return $this->validResponse([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'roles' => ['user'],
            'expires_in' => $token->accessToken->expires_at,
        ]);
    }

    public function providerLogin(AuthRequest $request)
    {
        $this->check($request, 'provider');

        $user = Auth::guard('provider')->user();
        $token = TokenController::createToken($user, $request->device_name);

        return $this->validResponse([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'roles' => ['user'],
            'expires_in' => $token->accessToken->expires_at,
        ]);
    }

    private function check($request, $guard = null)
    {
        if (! Auth::guard($guard)->attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
    }
}
