<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    public function __construct(
        protected CategoryRepository $repository
    ) {}

    /**
     * List category.
     */
    public function paginate(
        int $perPage = 15,
        ?string $search = null,
        ?bool $active = null
    ): LengthAwarePaginator {

        return $this->repository->paginate(
            $perPage,
            $search,
            $active
        );
    }

    /**
     * Active category.
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Detail category.
     */
    public function find(int $id): Category
    {
        return $this->repository->find($id);
    }

    /**
     * Create category.
     */
    public function create(array $data): Category
    {
        if ($this->repository->existsCode($data['code'])) {

            throw ValidationException::withMessages([
                'code' => 'Kode kategori sudah digunakan.',
            ]);

        }

        if ($this->repository->existsName($data['name'])) {

            throw ValidationException::withMessages([
                'name' => 'Nama kategori sudah digunakan.',
            ]);

        }

        return $this->repository->create($data);
    }

    /**
     * Update category.
     */
    public function update(
        Category $category,
        array $data
    ): Category {

        if ($this->repository->existsCode(
            $data['code'],
            $category->id
        )) {

            throw ValidationException::withMessages([
                'code' => 'Kode kategori sudah digunakan.',
            ]);

        }

        if ($this->repository->existsName(
            $data['name'],
            $category->id
        )) {

            throw ValidationException::withMessages([
                'name' => 'Nama kategori sudah digunakan.',
            ]);

        }

        return $this->repository->update(
            $category,
            $data
        );
    }

    /**
     * Delete.
     */
    public function delete(Category $category): bool
    {
        return $this->repository->delete($category);
    }

    /**
     * Restore.
     */
    public function restore(int $id): bool
    {
        return $this->repository->restore($id);
    }

    /**
     * Permanent delete.
     */
    public function forceDelete(int $id): bool
    {
        return $this->repository->forceDelete($id);
    }
}
