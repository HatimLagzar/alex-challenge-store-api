<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Api\BaseController;
use App\Models\Product;
use App\Services\Core\Product\ProductService;
use App\Services\Domain\Product\DeleteProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @OA\DELETE (
 *     path="/api/products/{id}",
 *     description="Delete a product",
 *     @OA\Parameter(
 *         name="id",
 *         description="ID of product",
 *         in = "path",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(response="default", description="Message of success when the product is deleted.")
 * )
 */
class DestroyController extends BaseController
{
    private DeleteProductService $deleteProductService;
    private ProductService $productService;

    public function __construct(DeleteProductService $deleteProductService, ProductService $productService)
    {
        $this->deleteProductService = $deleteProductService;
        $this->productService = $productService;
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $product = $this->productService->findById($id);
            if (!$product instanceof Product) {
                return $this->withError('Product not found!', Response::HTTP_NOT_FOUND);
            }

            $this->deleteProductService->delete($product);

            return $this->withSuccess([
                'message' => 'Your product has been deleted successfully.'
            ]);
        } catch (Throwable $e) {
            Log::error('failed to delete product', [
                'error_message' => $e->getMessage(),
            ]);

            return $this->withError('Error occurred, please retry later!');
        }
    }
}
