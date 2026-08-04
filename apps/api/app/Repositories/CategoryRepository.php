<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    /**
     * Get all categories with pagination.
     */
    public function paginate(
        int $perPage = 15,
        ?string $search = null,
        ?bool $active = null
    ): LengthAwarePaginator {

        return Category::query()

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");

                });

            })

            ->when(! is_null($active), function ($query) use ($active) {

                $query->where('active', $active);

            })

            ->latest()

            ->paginate($perPage)

            ->withQueryString();
    }

    /**
     * Get all active categories.
     */
    public function all(): Collection
    {
        return Category::where('active', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * Find category by id.
     */
    public function find(int $id): Category
    {
        return Category::findOrFail($id);
    }

    /**
     * Find by public id.
     */
    public function findByPublicId(string $publicId): Category
    {
        return Category::where('public_id', $publicId)->firstOrFail();
    }

    /**
     * Store category.
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update category.
     */
    public function update(Category $category, array $data): Category
    {
        $category->update($data);

        return $category->refresh();
    }

    /**
     * Soft delete.
     */
    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    /**
     * Restore.
     */
    public function restore(int $id): bool
    {
        return Category::onlyTrashed()

            ->findOrFail($id)

            ->restore();
    }

    /**
     * Force delete.
     */
    public function forceDelete(int $id): bool
    {
        return Category::onlyTrashed()

            ->findOrFail($id)

            ->forceDelete();
    }

    /**
     * Check duplicate code.
     */
    public function existsCode(
        string $code,
        ?int $ignoreId = null
    ): bool {

        return Category::where('code', $code)

            ->when($ignoreId, function ($query) use ($ignoreId) {

                $query->where('id', '!=', $ignoreId);

            })

            ->exists();
    }

    /**
     * Check duplicate name.
     */
    public function existsName(
        string $name,
        ?int $ignoreId = null
    ): bool {

        return Category::where('name', $name)

            ->when($ignoreId, function ($query) use ($ignoreId) {

                $query->where('id', '!=', $ignoreId);

            })

            ->exists();
    }
}
