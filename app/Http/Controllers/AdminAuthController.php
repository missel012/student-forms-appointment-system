<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = JWTAuth::fromUser($admin);

        return response()->json(compact('token'));
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::parseToken()->invalidate();
        } catch (JWTException $e) {
            // Log any exception that occurs during token invalidation
            Log::error('Error occurred during token invalidation', ['exception' => $e]);
            
            // Return a 500 Internal Server Error response with a generic message
            return response()->json(['error' => 'Could not logout, please try again later'], 500);
        }

        // If token invalidation was successful, return a success response
        return response()->json(['message' => 'Admin logged out successfully']);
    }
}
