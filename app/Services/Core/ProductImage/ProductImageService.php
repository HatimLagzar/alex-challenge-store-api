<?php

namespace App\Services\Core\ProductImage;

use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\ProductImage\ProductImageRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductImageService
{
    private ProductImageRepository $productImageRepository;

    public function __construct(ProductImageRepository $productImageRepository)
    {
        $this->productImageRepository = $productImageRepository;
    }

    /**
     * @param Product $product
     * @return Collection|ProductImage[]
     */
    public function getAllByProduct(Product $product): Collection
    {
        return $this->productImageRepository->getAllByProduct($product);
    }

    public function create(Product $product, array $attributes): ProductImage
    {
        $attributes[ProductImage::PRODUCT_ID_COLUMN] = $product->getId();

        return $this->productImageRepository->create($attributes);
    }

    public function deleteAllByProduct(Product $product): int
    {
        return $this->productImageRepository->deleteAllByProduct($product->getId());
    }
}