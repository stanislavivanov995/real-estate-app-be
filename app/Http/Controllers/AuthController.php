<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'fix errors', 'errors' => $validator->errors()], 500);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['status' => true, 'user' => $user]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $token = $user->createToken('jwt')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24, httpOnly: false); // 1 day

        return response([
            'user' => $user,
            'jwt' => $token
        ])->withCookie($cookie);
    }

    public function user()
    {
        return Auth::user();
    }

    public function logout(Request $request)
    {
        $cookie = Cookie::forget('jwt');

        $request->user()->tokens()->delete();

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }


    public function getUserProperties(): JsonResponse
    {
        $properties = Auth::user()->userProperties;

        return response()->json($properties);
    }

    public function getUserReservations(): JsonResponse
    {
        $reservations = Auth::user()->estates;

        return response()->json($reservations);
    }
}
