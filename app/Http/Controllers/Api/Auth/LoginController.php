<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __construct(private readonly User $model)
    {
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = $this->model->where('email', $request->validated('email'))->first();

        abort_if(
            !Hash::check($request->validated('password'), $user?->password),
            404,
            'The credentials are invalid'
        );

        $token = $user->createToken('firsttoken')->plainTextToken;

        if (Auth::attempt($credentials)) {
            return new JsonResponse([
                'user' => $user,
                'token' => $token
            ], 201);
        }

        return new JsonResponse(['error' => 'The provided credentials do not match our records.'], 200);
    }
}
