<?php

namespace App\Services\Domain\ProductVariant;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\Core\ProductVariant\ProductVariantService;

class CreateProductVariantsService
{
    private ProductVariantService $productVariantService;

    public function __construct(ProductVariantService $productVariantService)
    {
        $this->productVariantService = $productVariantService;
    }

    public function create(Product $product, array $variants)
    {
        foreach ($variants as $variant) {
            if (empty($variant['size']) || empty($variant['stock'])) {
                continue;
            }

            $this->productVariantService->create(
                $product,
                [
                    ProductVariant::SIZE_COLUMN => $variant['size'],
                    ProductVariant::STOCK_COLUMN => $variant['stock'],
                ]
            );
        }
    }
}
