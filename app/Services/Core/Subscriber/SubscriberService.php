<?php

namespace App\Services\Core\Subscriber;

use App\Models\Subscriber;
use App\Repositories\Subscriber\SubscriberRepository;

class SubscriberService
{
    private SubscriberRepository $subscriberRepository;

    public function __construct(SubscriberRepository $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    public function create($attributes): Subscriber
    {
        return $this->subscriberRepository->create($attributes);
    }

    public function findByEmail(string $email): ?Subscriber
    {
        return $this->subscriberRepository->findByEmail($email);
    }
}