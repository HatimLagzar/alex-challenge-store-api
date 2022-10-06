<?php

namespace App\Services\Domain\ProductImage;

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\Core\ProductImage\ProductImageService;

class CreateProductImagesService
{
    private ProductImageService $productImageService;

    public function __construct(ProductImageService $productImageService)
    {
        $this->productImageService = $productImageService;
    }

    public function upload(Product $product, array $extraImages)
    {
        foreach ($extraImages as $extraImage) {
            $imageFileName = $extraImage->hashName();
            $extraImage->storeAs('public/products_images', $imageFileName);
            $this->productImageService->create($product, [
                ProductImage::FILENAME_COLUMN => $imageFileName
            ]);
        }
    }
}