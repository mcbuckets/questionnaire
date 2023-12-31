<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final class SymfonyExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $response = $this->createApiResponse($event->getThrowable());
        $event->setResponse($response);
    }

    private function createApiResponse(\Throwable $exception): JsonResponse
    {
        $statusCode = $exception instanceof HttpExceptionInterface && $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        return new JsonResponse(['error_message' => $exception->getMessage(), 'code' => $statusCode], $statusCode);
    }
}
