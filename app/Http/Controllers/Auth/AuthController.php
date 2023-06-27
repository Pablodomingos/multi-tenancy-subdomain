<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\UnauthorizedCustomException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct(
        private User $user
    )
    {
    }

    public function logout(Request $request): JsonResponse
    {
        if (auth()->check()) {
            Auth::user()->tokens()->delete();
        }

        return response()->json('', Response::HTTP_NO_CONTENT);
    }

    public function login(Request $request)
    {
        /** @var User $user */
        $user = $this->user->newQuery()->where('email', '=', Str::lower($request->email))->first();

        if (! Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            throw new UnauthorizedCustomException(trans('custom.unauthorized_login'));
        }

        $token = $user->createToken('auth_token');

        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }
}
