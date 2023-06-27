<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        private User $user,
        private Tenant $tenant
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->user->all()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|min:8|max:255|unique:users,email',
            'password' => 'required|string|max:255'
        ]);

        try {
            $attributes = Arr::only($data, $this->user->getFillableColumns());
            /** @var Tenant $tenent */
            $tenent = $this->tenant->newQuery()->firstOrFail();
            $attributes['tenant_id'] = $tenent->id;
            $user = $this->user->newQuery()->create($attributes);
            $token = $user->createToken('auth_token');

            return response()->json([
                'access_token' => $token->plainTextToken,
                'token_type' => 'Bearer',
                'user' => $user
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

    }

    public function show(int $id)
    {
        return response()->json(
            $this->user->newQuery()->findOrFail($id)
        );
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => "sometimes|string|email|max:255|unique:users,email,$id,id",
            'password' => 'sometimes|string|min:8|max:255'
        ]);

        try {
            $user = $this->user->newQuery()->findOrFail($id);
            $attribute = Arr::only($data, $user->getFillableColumns());
            $user->update($attribute);

            return response()->json(
                $user
            );
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function destroy(int $id)
    {
        return response()->json(
            $this->user->newQuery()
                ->findOrFail($id)
                ->delete()
        );
    }
}
