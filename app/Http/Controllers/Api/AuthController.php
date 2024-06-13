<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken($request->email)->accessToken;
            return $token;
        } else {
            return response()->json(['error' => 'Either Email or passowrd is incorrect.'], 401);
        }

    }

    public static function validateToken()
    {
        $validated = Auth::user() ? true : false;

        return response()->json([
            'validated' => $validated
        ]);
    }

    public static function logout()
    {
        Auth::user()->token()->revoke();
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return $token;
    }
}
