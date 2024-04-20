<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        Auth::shouldUse('web');
        if (Auth::attempt($credentials)) {
            // successfull authentication
            $user = User::find(Auth::user()->id);

            $user_token['token'] = $user->createToken('appToken')->accessToken;

            return response()->json([
                'success' => true,
                'token' => $user_token,
                'user' => $user,
            ], 200);
        } else {
            // failure to authenticate
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }


    function store(Request $request)
    {
        $credentials = $request->only('name', 'email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'name' => 'required|string',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
        ]);
        if ($user) {
            $user_token['token'] = $user->createToken('appToken')->accessToken;

            return response()->json([
                'success' => true,
                'token' => $user_token,
                'user' => $user,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register.',
            ], 401);
        }
    }

    function destroy(Request $request)
    {
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->token()->revoke();
            return response()->json(['message' => 'Logged out successfully'], 204);
        } else {
            return response()->json(['error' => 'Failed'], 400);
        }
    }
}
