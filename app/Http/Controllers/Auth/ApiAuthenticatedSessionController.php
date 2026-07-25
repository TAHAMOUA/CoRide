<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ApiAuthenticatedSessionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $rawContent = $request->getContent();
        $payload = $request->json()->all();

        if (! is_array($payload) || empty($payload)) {
            $payload = json_decode($rawContent, true) ?: [];
        }

        if ((! is_array($payload) || empty($payload)) && is_string($rawContent)) {
            $decodedOnce = json_decode($rawContent, true);

            if (is_string($decodedOnce)) {
                $payload = json_decode($decodedOnce, true) ?: [];
            }

            if ((! is_array($payload) || empty($payload)) && ! empty($rawContent)) {
                $payload = json_decode(stripslashes($rawContent), true) ?: $payload;
            }
        }

        if (! is_array($payload)) {
            $payload = [];
        }

        $attributes = array_merge($request->only(['email', 'password']), $request->all(), $payload);

        $validated = validator($attributes, [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ])->validate();

        $employe = Employe::where('email', $validated['email'])->first();

        if (! $employe || ! Hash::check($validated['password'], $employe->password)) {
            return response()->json([
                'message' => 'Identifiants invalides.',
            ], 422);
        }

        $token = $employe->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ]);
    }
}
