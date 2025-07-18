<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    // public function __invoke(Request $request)
    public function login(Request $request)
    {
        $user = User::where('email', $request->get('usernmae'))->first();

        if (!$user || !Hash::check($request->get('password'), $user->password)) {
            throw ValidationException::withMessages([
                'credentials' => 'The credentials are incorrect.',
            ]);
        }

        return [
            'access_token' => $user->createToken($user->name.$user->create_at)->plainTextToken
        ];
    }

    public function logout()
    {
        $user = auth()->user();

        // dd($user->tokens);

        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Token revoked.'], JsonResponse::HTTP_OK);
    }
}
