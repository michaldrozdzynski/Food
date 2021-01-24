<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Storage;
use URL;

class UserController extends Controller
{
    public function register(RegisterUser $request): JsonResponse
    {
        $data = $request->validated();
        if (isset($data['avatar']))
        {
            $data['avatar'] = $request->file('avatar')->store('/public/images/avatar');
        }

        $data['password'] = bcrypt($request->password);
        
        return response()->json(User::create($data),201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } 

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Succesfully logget out'
        ]);
    }

    public function update(UpdateUser $request): JsonResponse
    {
        $data = $request->validated();
        $user = Auth::user();

        if (isset($data['avatar'])) {
            $data['avatar'] = $request->file('avatar')->store('public/images/avatar');

            if (isset($user->avatar)) {
                Storage::delete($user->avatar);
            }
        }

        
        $user->update($data);
        $user->avatar = URL::to('/') . '/storage//' . substr($user->avatar, 7);
        
        return response()->json($user);
    }

    public function show(User $user): JsonResponse
    {
        $user->avatar = URL::to('/') . '/storage//' . substr($user->avatar, 7);

        return response()->json($user);
    }
}
