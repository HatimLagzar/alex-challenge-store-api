<?php

namespace App\Services\Core\Order;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Product\ProductRepository;

class OrderService
{
    private OrderRepository $orderRepository;
    private ProductRepository $productRepository;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function create(array $attributes): Order
    {
        return $this->orderRepository->create($attributes);
    }

    public function findById(string $id): ?Order
    {
        $order = $this->orderRepository->findById($id);
        if (!$order instanceof Order) {
            return null;
        }

        return $this->hydrate($order);
    }

    private function hydrate(Order $order): Order
    {
        $product = $this->productRepository->findById($order->getProductId());
        if ($product instanceof Product) {
            $order->setProduct($product);
        }

        return $order;
    }

    public function update(Order $order, array $attributes): bool
    {
        return $this->orderRepository->update($order->getId(), $attributes);
    }
}