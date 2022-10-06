<?php

namespace App\Services\Domain\Product;

use App\Models\Product;
use App\Services\Core\Product\ProductService;
use App\Services\Core\ProductImage\ProductImageService;
use Illuminate\Filesystem\FilesystemManager;

class DeleteProductService
{
    private FilesystemManager $filesystemManager;
    private ProductImageService $productImageService;
    private ProductService $productService;

    public function __construct(
        ProductImageService $productImageService,
        FilesystemManager $filesystemManager,
        ProductService $productService
    ) {
        $this->filesystemManager = $filesystemManager;
        $this->productImageService = $productImageService;
        $this->productService = $productService;
    }

    public function delete(Product $product): bool
    {
        $this->filesystemManager->delete('public/products_thumbnails/' . $product->getThumbnail());

        $productImages = $this->productImageService->getAllByProduct($product);

        $productImagesPaths = $productImages->map(fn($item) => 'public/products_images/' . $item->filename)->toArray();

        $this->filesystemManager->delete($productImagesPaths);

        return $this->productService->delete($product);
    }
}
