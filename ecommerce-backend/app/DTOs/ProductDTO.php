<?php

namespace App\DTOs;

class ProductDTO
{
    public function __construct(
        public string $name,
        public float $price,
        public string $description,
        public string $category,
        public ?string $image_url = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            price: (float) $data['price'],
            description: $data['description'],
            category: $data['category'],
            image_url: $data['image_url'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name'        => $this->name,
            'price'       => $this->price,
            'description' => $this->description,
            'category'    => $this->category,
            'image_url'   => $this->image_url,
        ];
    }
}
