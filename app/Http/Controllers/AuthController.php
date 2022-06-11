<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $user = User::where('email', $request->get('email'))->first();

        if (!$user || !Hash::check($request->get('password'), $user->password))
            return response()->json([
                'message' => __('auth.failed')
            ]);

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->createToken(md5(rand()))->plainTextToken
        ]);
    }

    public function user(Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
