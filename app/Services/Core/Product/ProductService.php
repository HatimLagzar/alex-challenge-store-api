<?php

namespace App\Services\Core\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductImage\ProductImageRepository;
use App\Repositories\ProductVariant\ProductVariantRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductService
{
    private ProductRepository $productRepository;
    private ProductVariantRepository $productVariantRepository;
    private ProductImageRepository $productImageRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductVariantRepository $productVariantRepository,
        ProductImageRepository $productImageRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->productImageRepository = $productImageRepository;
    }

    /**
     * @return LengthAwarePaginator|Product[]
     */
    public function getPaginated(): LengthAwarePaginator
    {
        $products = $this->productRepository->getPaginated();

        $products->setCollection($products->getCollection()->transform(function (Product $product) {
            return $this->hydrate($product);
        }));

        return $products;
    }

    /**
     * @return Collection|Product[]
     */
    public function getAll(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function delete(Product $product): bool
    {
        return $this->productRepository->delete($product->getId());
    }

    public function findById(string $id): ?Product
    {
        $product = $this->productRepository->findById($id);
        if (!$product instanceof Product) {
            return null;
        }

        return $this->hydrate($product);
    }

    public function create(array $attributes): Product
    {
        return $this->productRepository->create($attributes);
    }

    public function update(Product $product, array $attributes): bool
    {
        return $this->productRepository->update($product->getId(), $attributes);
    }

    private function hydrate(Product $product): Product
    {
        $productVariants = $this->productVariantRepository->getAllByProduct($product->getId());
        $product->setVariants($productVariants);

        $extraImages = $this->productImageRepository->getAllByProduct($product->getId());
        $product->setExtraImages($extraImages);

        return $product;
    }
}
