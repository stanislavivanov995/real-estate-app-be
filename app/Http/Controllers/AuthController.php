<?php

namespace App\Http\Controllers;

use APP\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function user() {
        return 'Successfully';
    }

    public function register(Request $request)
    {
        $user = USER::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password) 
        ]);

        return response()->json($user);
    }

    public function login(Request $request) {
        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'message' => 'Login failed',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}