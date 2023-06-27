<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class TenantController extends Controller
{
    public function __construct(
        private Tenant $tenant
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->tenant->all()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tenants,name',
            'subdomain' => 'required|string|max:255|unique:tenants,subdomain'
        ]);

        try {
            $attributes = Arr::only($data, $this->tenant->getFillableColumns());

            return response()->json(
                $this->tenant->newQuery()->create($attributes)
            , Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            $this->tenant->newQuery()->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'name' => "sometimes|string|max:255|unique:tenants,name,$id,id",
            'subdomain' => "sometimes|string|max:255|unique:tenants,subdomain,$id,id"
        ]);

        try {
            $tenant = $this->tenant->newQuery()->findOrFail($id);
            $attributes = Arr::only($data, $tenant->getFillableColumns());
            $tenant->update($attributes);

            return response()->json(
                $tenant
            );
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json(
            $this->tenant->newQuery()
                ->findOrFail($id)
                ->delete()
        );
    }
}
