<?php

namespace App\Transformers\ProductImage;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Collection;

class ProductImageTransformer
{
    /**
     * @param Collection|ProductImage[] $products
     * @return Collection
     */
    public function transformMany(Collection $products): Collection
    {
        return $products->transform(function (ProductImage $productImage) {
            return $this->transform($productImage);
        });
    }

    public function transform(ProductImage $productImage): array
    {
        return [
            'id'        => $productImage->getId(),
            'productId' => $productImage->getProductId(),
            'filename'  => url('storage/products_images/' . $productImage->getFileName())
        ];
    }
}
