<?php

namespace App\Repositories\ProductVariant;

use App\Models\ProductVariant;

class ProductVariantRepository
{
    public function create(array $attributes): ProductVariant
    {
        return ProductVariant::query()
            ->create($attributes);
    }

    public function getAllByProduct(string $productId)
    {
        return ProductVariant::query()
            ->where(ProductVariant::PRODUCT_ID_COLUMN, $productId)
            ->get();
    }

    public function deleteAllByProduct(string $productId): int
    {
        return ProductVariant::query()
            ->where(ProductVariant::PRODUCT_ID_COLUMN, $productId)
            ->delete();
    }
}