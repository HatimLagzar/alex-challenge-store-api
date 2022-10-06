<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class RefreshController extends BaseController
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $token = Auth::guard('api')->refresh(true, true);

            return $this->withSuccess([
                'message' => 'Refreshed successfully!',
                'token'   => $token
            ]);
        } catch (Throwable $e) {
            return $this->withError('Failed to refresh token due to internal error!');
        }
    }
}
