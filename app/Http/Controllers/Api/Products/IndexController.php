<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Api\BaseController;
use App\Services\Core\Product\ProductService;
use App\Transformers\Product\ProductTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * @OA\Get (
 *     path="/api/products",
 *     description="List of products paginated",
 *     @OA\Response(response="default", description="List of products paginated.")
 * )
 */
class IndexController extends BaseController
{
    private ProductService $productService;
    private ProductTransformer $productTransformer;

    public function __construct(
        ProductService $productService,
        ProductTransformer $productTransformer
    ) {
        $this->productService = $productService;
        $this->productTransformer = $productTransformer;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $products = $this->productService->getPaginated();

            $products->setCollection($this->productTransformer->transformMany($products->getCollection()));

            return $this->withSuccess([
                'products' => $products
            ]);
        } catch (Throwable $e) {
            Log::error('failed to list product', [
                'error_message' => $e->getMessage()
            ]);

            return $this->withError('Error occurred, please retry later!');
        }
    }
}
