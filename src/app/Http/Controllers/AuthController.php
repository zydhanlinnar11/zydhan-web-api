<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        if(Auth::attempt($request->safe(['email', 'password']))) {
            return response()->json(['message' => 'Authenticated']);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return response()->json(['message' => 'Successfully created user.'], 201);
    }
}
