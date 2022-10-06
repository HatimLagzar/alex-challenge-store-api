<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\Core\Product\ProductService;
use App\Services\Domain\Product\Exceptions\InvalidPayloadException;
use App\Services\Domain\Product\UpdateProductService;
use App\Transformers\Product\ProductTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdateController extends BaseController
{
    private UpdateProductService $updateProductService;
    private ProductService $productService;
    private ProductTransformer $productTransformer;

    public function __construct(
        UpdateProductService $updateProductService,
        ProductService $productService,
        ProductTransformer $productTransformer
    ) {
        $this->updateProductService = $updateProductService;
        $this->productService = $productService;
        $this->productTransformer = $productTransformer;
    }

    public function __invoke(UpdateProductRequest $request, string $id): JsonResponse
    {
        try {
            $product = $this->productService->findById($id);
            if (!$product instanceof Product) {
                return $this->withError('Product not found!', Response::HTTP_NOT_FOUND);
            }

            $product = $this->updateProductService->update($product, $request->all());

            return $this->withSuccess([
                'message' => 'Your product has been updated successfully.',
                'product' => $this->productTransformer->transform($product),
            ]);
        } catch (InvalidPayloadException $e) {
            return $this->withError('Invalid data sent!', Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $e) {
            Log::error('failed to update product', [
                'error_message' => $e->getMessage(),
            ]);

            return $this->withError('Error occurred, please retry later!');
        }
    }
}
