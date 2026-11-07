<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JwtAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
        $guard = Auth::guard('api');
        $token = $guard->attempt($credentials);
        if (! $token) {
            return response()->json(['message' => 'Credenciales incorrectas.'], 401);
        }
        return response()->json([
            'message' => 'Autenticación exitosa.',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'expires_in' => $guard->factory()->getTTL() * 60,
        ]);
    }

    public function me(): JsonResponse
    {
        return response()->json(['user' => Auth::guard('api')->user()]);
    }

    public function logout(): JsonResponse
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Token invalidado.']);
    }
}
