<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{


    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in the user
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user(); // Get the authenticated user
            return response()->json(['success' => 'Login Approved', 'user' => $user], 200);
        }

        // If login fails, return an error
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
{
    // Custom validation for clarity
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Create the user
    try {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate API token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return success response
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'User registration failed', 'details' => $e->getMessage()], 500);
    }
}

}
