<?php

namespace App\Services\Core\ProductVariant;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\ProductVariant\ProductVariantRepository;

class ProductVariantService
{
    private ProductVariantRepository $productVariantRepository;

    public function __construct(ProductVariantRepository $productVariantRepository)
    {
        $this->productVariantRepository = $productVariantRepository;
    }

    public function deleteAllByProduct(Product $product): int
    {
        return $this->productVariantRepository->deleteAllByProduct($product->getId());
    }

    public function create(Product $product, array $attributes): ProductVariant
    {
        $attributes[ProductVariant::PRODUCT_ID_COLUMN] = $product->getId();

        return $this->productVariantRepository->create($attributes);
    }
}