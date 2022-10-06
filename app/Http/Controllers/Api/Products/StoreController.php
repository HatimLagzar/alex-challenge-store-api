<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Product\CreateProductRequest;
use App\Services\Domain\Product\CreateProductService;
use App\Services\Domain\Product\Exceptions\InvalidPayloadException;
use App\Transformers\Product\ProductTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class StoreController extends BaseController
{
    private CreateProductService $createProductService;
    private ProductTransformer $productTransformer;

    public function __construct(
        CreateProductService $createProductService,
        ProductTransformer $productTransformer
    ) {
        $this->createProductService = $createProductService;
        $this->productTransformer = $productTransformer;
    }

    public function __invoke(CreateProductRequest $request): JsonResponse
    {
        try {
            $product = $this->createProductService->create($request->all());

            return $this->withSuccess([
                'message' => 'Your product has been created successfully.',
                'product' => $this->productTransformer->transform($product),
            ]);
        } catch (InvalidPayloadException $e) {
            return $this->withError('Invalid data sent!', Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $e) {
            Log::error('failed to create product', [
                'error_message' => $e->getMessage(),
            ]);

            return $this->withError('Error occurred, please retry later!');
        }
    }
}
