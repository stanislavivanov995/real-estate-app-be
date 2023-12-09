<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Logging\Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $registeredUser = User::whereEmail($request->email)->first();

        if ($registeredUser) {
            return response([
                'success' => false,
                'message' => 'This email address is already registered'
            ]);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response([
            'success' => true,
            'message' => 'Successfully created',
        ]);
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
