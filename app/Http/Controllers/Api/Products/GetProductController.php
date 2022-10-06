<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Api\BaseController;
use App\Models\Product;
use App\Services\Core\Product\ProductService;
use App\Transformers\Product\ProductTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @OA\Get(
 *     path="/api/products/{id}",
 *     description="Find a product and return it",
 *     @OA\Parameter(
 *         name="id",
 *         description="ID of product",
 *         in = "path",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(response="default", description="Return the product details")
 * )
 */
class GetProductController extends BaseController
{
    private ProductService $productService;
    private ProductTransformer $productTransformer;

    public function __construct(ProductService $productService, ProductTransformer $productTransformer)
    {
        $this->productService = $productService;
        $this->productTransformer = $productTransformer;
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $product = $this->productService->findById($id);
            if (!$product instanceof Product) {
                return $this->withError('Product not found!', Response::HTTP_NOT_FOUND);
            }

            return $this->withSuccess([
                'message' => 'Product fetched successfully.',
                'product' => $this->productTransformer->transform($product)
            ]);
        } catch (Throwable $e) {
            Log::error('failed to get product', [
                'error_message' => $e->getMessage(),
            ]);

            return $this->withError('Error occurred, please retry later!');
        }
    }
}
