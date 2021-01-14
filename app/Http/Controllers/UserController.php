<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RegisterUser;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function register(RegisterUser $request): JsonResponse
    {
        $data = $request->validated();
        if (isset($data['avatar']))
        {
            $data['avatar'] = $request->file('avatar')->store('images/avatar');
        }

        $data['password'] = bcrypt($request->password);
        
        return response()->json(User::create($data),201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json('Succes', 200);
        } else {
            return response()->json('Wrong email or password.', 401);
        }
    }
}
