<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $service
    ) {}

    /**
     * Display a listing.
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = $this->service->paginate(
            perPage: request()->integer('per_page', 15),
            search: request('search'),
            active: request()->has('active')
                ? filter_var(request('active'), FILTER_VALIDATE_BOOLEAN)
                : null
        );

        return CategoryResource::collection($categories);
    }

    /**
     * Store.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->service->create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dibuat.',
            'data' => new CategoryResource($category),
        ], 201);
    }

    /**
     * Show.
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new CategoryResource($category),
        ]);
    }

    /**
     * Update.
     */
    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ): JsonResponse {

        $category = $this->service->update(
            $category,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui.',
            'data' => new CategoryResource($category),
        ]);
    }

    /**
     * Delete.
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->service->delete($category);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus.',
        ]);
    }
}
