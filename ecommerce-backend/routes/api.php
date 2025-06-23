<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{id}', function ($id) {
    $product = App\Models\Product::find($id);

    if (!$product) {
        return response()->json(['error' => 'Produto não encontrado'], 404);
    }

    return response()->json($product);
});
