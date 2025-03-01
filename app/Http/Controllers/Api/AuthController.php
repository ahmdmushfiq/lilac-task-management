<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;


        if ($email == null || $email == '') {
            return response()->json([
                'status' => false,
                'message' => 'email is required',
            ], 400);
        }
        if ($password == null || $password == '') {
            return response()->json([
                'status' => false,
                'message' => 'password is required',
            ], 400);
        }
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 400);
        }
        if (Hash::check($password, $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            $user['token'] = $token;
            return response()->json([
                'status' => true,
                'message' => 'Login successfull',
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect password',
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logout successfull',
        ], 200);
    }
}
