<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(protected ProductRepository $repository) {}

    public function list(array $filters): LengthAwarePaginator
    {
        return $this->repository->getFiltered($filters);
    }

    public function find(int $id): ?Product
    {
        return $this->repository->find($id);
    }

    public function create(ProductDTO $dto): Product
    {
        return $this->repository->create($dto->toArray());
    }

    public function update(Product $product, ProductDTO $dto): Product
    {
        return $this->repository->update($product, $dto->toArray());
    }

    public function delete(Product $product): bool
    {
        return $this->repository->delete($product);
    }

    public function findByName(string $name): ?Product
    {
        return $this->repository->findByName($name);
    }
}
