<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // Register user
    public function store(RegisterUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký tài khoản thành công'
        ], 200);
    }

    // Login user
    public function show(LoginUserRequest $request)
    {
        $credentials = $request->only(['email','password']);

        if (Auth::attempt($credentials)) {
            return response()->json([
                'success' => true,
                'token' => Auth::user()->createToken('token')->plainTextToken,
                'user' => Auth::user()
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Tên tài khoản hoặc mật khẩu không chính xác'
        ], 404);
    }
  
}
