<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'User registered successfully',
            'data' => $user,
        ], 201);
    }

    // Login user and issue token
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         $token = $user->createToken('Personal Access Token')->accessToken;

    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Login successful',
    //             'token' => $token,
    //             'user' => $user,
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => 401,
    //         'message' => 'Invalid credentials',
    //     ], 401);
    // }

    // Login user and issue token
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid credentials',
            ], 401);
        }

        // If credentials are correct, create a token for the user
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ]);
    }

    // Logout user and revoke token
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'status' => 200,
            'message' => 'Logged out successfully',
        ]);
    }
}
