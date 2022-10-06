<?php

namespace App\Services\Domain\Order\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidPayloadException extends Exception
{
    public function __construct()
    {
        parent::__construct('Missing attribute', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}