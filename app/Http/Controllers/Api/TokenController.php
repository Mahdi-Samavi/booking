<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TokenCollection;
use DateTimeInterface;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tokens = request()->user()->tokens()->get();

        return new TokenCollection($tokens);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_name' => ['required', 'string'],
        ]);

        $token = self::createToken(request()->user(), $request->device_name);

        return $this->validResponse([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'roles' => ['user'],
            'expires_in' => $token->accessToken->expires_at,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        request()->user()->tokens()->where('id', $id)->delete();

        return $this->validResponse();
    }

    /**
     * Create a token
     *
     * @param  \App\Models\User  $user
     * @param  string  $name
     * @param  array  $abilities
     * @param  \DateTimeInterface|null  $expiresAt
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public static function createToken($user, $name, array $abilities = ['*'], DateTimeInterface $expiresAt = null)
    {
        return $user->createToken($name, $abilities, $expiresAt);
    }
}
