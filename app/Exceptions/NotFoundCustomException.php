<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class NotFoundCustomException extends Exception
{
    public function __construct(string $message, Response|int $code = 0, Throwable $previous = null) {
        parent::__construct($message, ResponseAlias::HTTP_NOT_FOUND, $previous);
    }

    public function report(): bool
    {
        return true;
    }

    public function render(Request $request): Response
    {
        return response([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
