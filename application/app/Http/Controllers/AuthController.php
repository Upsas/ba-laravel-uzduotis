<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request): Response|Application|ResponseFactory
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('myAppToken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(LoginRequest $loginRequest): ResponseFactory|Application|Response
    {
        $loginData = ($loginRequest->validated());

        $user = User::where('email', $loginData['email'])->first();
        if (!$user || !Hash::check($loginData['password'], $user->password)) {
            return response([
                'message' => 'Bad cradentionals'
            ], 401);
        }
        $token = $user->createToken('myAppToken')->plainTextToken;

        return response(
            [
                'user' => $user,
                'token' => $token
            ], 201);
    }

    public function logout(): Response
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Successfully logged out'
        ]);
    }
}
