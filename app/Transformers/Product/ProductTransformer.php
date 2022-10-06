<?php

namespace App\Transformers\Product;

use App\Models\Product;
use App\Transformers\ProductImage\ProductImageTransformer;
use Illuminate\Support\Collection;

class ProductTransformer
{
    private ProductImageTransformer $productImageTransformer;

    public function __construct(ProductImageTransformer $productImageTransformer)
    {
        $this->productImageTransformer = $productImageTransformer;
    }

    /**
     * @param Collection|Product[] $products
     * @return Collection
     */
    public function transformMany(Collection $products): Collection
    {
        return $products->transform(function (Product $product) {
            return $this->transform($product);
        });
    }

    public function transform(Product $product): array
    {
        return [
            'id'                       => $product->getId(),
            'title'                    => $product->getTitle(),
            'description'              => $product->getDescription(),
            'thumbnail'                => url('storage/products_thumbnails/' . $product->getThumbnail()),
            'price'                    => $product->getPrice(),
            'priceFormatted'           => $product->getPriceFormatted() . ' MAD',
            'discount'                 => $product->getDiscount(),
            'priceDiscountedFormatted' => number_format($product->getPriceFormatted() - ($product->getPriceFormatted() * $product->getDiscount()) / 100,
                    2) . ' MAD',
            'variants'                 => $product->getVariants(),
            'extraImages'              => $product->getExtraImages() ? $this->productImageTransformer->transformMany($product->getExtraImages()) : null,
        ];
    }
}
