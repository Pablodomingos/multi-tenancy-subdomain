<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        private readonly Post $post
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->post->all()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|min:4|max:255',
            'body' => 'required|string|min:5|max:1000',
            'image' => 'sometimes|nullable|url'
        ]);

        try {
            $attributes = Arr::only($data, $this->post->getFillableColumns());

            return response()->json(
                auth()->user()->posts()->create($attributes)
            );
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(
            $this->post->newQuery()->findOrFail($id)
        );
    }

    public function update(Request $request, string $id): JsonResponse
    {
        return response()->json(
            //
        );
    }

    public function destroy(string $id): JsonResponse
    {
        return response()->json(
            $this->post->newQuery()->findOrFail($id)->delete()
        );
    }
}
