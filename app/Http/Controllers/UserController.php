<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->all())) {
            return response()->json(['message' => 'Not Authorized.'], 403);
        }

        return response()->json(['message' => 'Authorized', "token" => $request->user()->createToken('token')->plainTextToken], 200);
    }

    public function store(UserRequest $request)
    {
        $data = $request->except(['_token']);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        Auth::login($user);

        return response()->json(['message' => 'Registered', "token" => $user->createToken('token')->plainTextToken], 200);
    }
}
