<?php

namespace App\Services\Domain\Product;

use App\Models\Product;
use App\Services\Core\Product\ProductService;
use App\Services\Core\ProductImage\ProductImageService;
use App\Services\Core\ProductVariant\ProductVariantService;
use App\Services\Domain\Product\Exceptions\InvalidPayloadException;
use App\Services\Domain\Product\Exceptions\InvalidProductVariantsException;
use App\Services\Domain\ProductImage\CreateProductImagesService;
use App\Services\Domain\ProductVariant\CreateProductVariantsService;
use Illuminate\Support\Arr;

class UpdateProductService
{
    private ProductService $productService;
    private ProductVariantService $productVariantService;
    private CreateProductImagesService $uploadProductImagesService;
    private ProductImageService $productImageService;
    private CreateProductVariantsService $createProductVariantsService;

    public function __construct(
        ProductService $productService,
        ProductVariantService $productVariantService,
        CreateProductImagesService $uploadProductImagesService,
        ProductImageService $productImageService,
        CreateProductVariantsService $createProductVariantsService
    ) {
        $this->productService = $productService;
        $this->productVariantService = $productVariantService;
        $this->uploadProductImagesService = $uploadProductImagesService;
        $this->productImageService = $productImageService;
        $this->createProductVariantsService = $createProductVariantsService;
    }

    /**
     * @throws InvalidProductVariantsException
     * @throws InvalidPayloadException
     */
    public function update(Product $product, array $attributes): ?Product
    {
        if (
            Arr::has($attributes, [
                'title',
                'price',
                'discount',
                'description',
                'variants'
            ]) === false
        ) {
            throw new InvalidPayloadException();
        }

        $title = htmlentities($attributes['title']);
        $price = filter_var($attributes['price'], FILTER_VALIDATE_FLOAT);
        $discount = filter_var($attributes['discount'], FILTER_VALIDATE_FLOAT);
        $description = htmlentities($attributes['description']);
        $variants = $attributes['variants'];

        $thumbnailFileName = $product->getThumbnail();
        if (Arr::has($attributes, 'thumbnail')) {
            $thumbnail = $attributes['thumbnail'];
            $thumbnailFileName = $thumbnail->hashName();
            $thumbnail->storeAs('public/products_thumbnails', $thumbnailFileName);
        }

        $this->productService->update($product, [
            Product::TITLE_COLUMN       => $title,
            Product::PRICE_COLUMN       => $price * 100,
            Product::DISCOUNT_COLUMN    => $discount,
            Product::DESCRIPTION_COLUMN => $description,
            Product::THUMBNAIL_COLUMN   => $thumbnailFileName
        ]);

        $this->productVariantService->deleteAllByProduct($product);
        $this->createProductVariantsService->create($product, $variants);

        if (Arr::has($attributes, 'extraImages')) {
            $this->productImageService->deleteAllByProduct($product);
            $extraImages = $attributes['extraImages'];
            $this->uploadProductImagesService->upload($product, $extraImages);
        }

        return $this->productService->findById($product->getId());
    }
}
