<?php

namespace App\Repositories\ProductImage;

use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;

class ProductImageRepository
{
    /**
     * @param string $id
     * @return Collection|ProductImage[]
     */
    public function getAllByProduct(string $id): Collection
    {
        return ProductImage::query()
            ->where(ProductImage::PRODUCT_ID_COLUMN, $id)
            ->get();
    }

    public function create(array $attributes): ProductImage
    {
        return ProductImage::query()
            ->create($attributes);
    }

    public function deleteAllByProduct(string $productId): int
    {
        return ProductImage::query()
            ->where(ProductImage::PRODUCT_ID_COLUMN, $productId)
            ->delete();
    }
}