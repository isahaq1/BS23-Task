<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    //Register New user
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

        
        return $this->sendResponse($user, 'User register successfully.',201);
    }

    // User  Login 
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            
            return $this->sendError('Unauthorised.', ['error'=>'Please check email or Password'],401);
            
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $success['access_token'] = $token;
        $success['token_type'] = 'Bearer';
        return $this->sendResponse($success, 'welcome.',200);
        
    }

    // User Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse('', 'Logged out successfully.',200);
    }
}
