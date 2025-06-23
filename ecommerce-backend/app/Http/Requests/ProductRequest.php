<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTOs\ProductDTO;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category' => 'required|string|max:120',
            'image_url' => 'nullable|url|max:255',
        ];
    }

    public function toDTO(): ProductDTO
    {
        return new ProductDTO(
            name: $this->input('name'),
            price: $this->input('price'),
            description: $this->input('description'),
            category: $this->input('category'),
            image_url: $this->input('image_url')
        );
    }
}
