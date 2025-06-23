<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    public function getFiltered(array $filters): LengthAwarePaginator
    {
        $query = Product::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['with_image']) && $filters['with_image']) {
            $query->whereNotNull('image_url');
        }

        if (!empty($filters['id'])) {
            $query->where('id', $filters['id']);
        }

        return $query->paginate(10);
    }

    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function findByName(string $name): ?\App\Models\Product
    {
        return \App\Models\Product::where('name', $name)->first();
    }
}
