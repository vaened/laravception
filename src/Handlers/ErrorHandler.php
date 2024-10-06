<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Throwable;
use Vaened\Laravception\Decoders\ExceptionNameParser;
use Vaened\Laravception\HttpExceptionStatusCodeMapping;
use Vaened\Laravception\Responses\ErrorResponse;
use Vaened\Laravception\Responses\ErrorResponseFactory;

abstract class ErrorHandler
{
    public function __construct(
        private readonly UrlGenerator         $url,
        private readonly ExceptionNameParser  $nameParser,
        private readonly ErrorResponseFactory $responseFactory,
    )
    {
    }

    final protected function shouldReturnJson(Request $request): bool
    {
        return $request->wantsJson() || $request->expectsJson();
    }

    final protected function isPreviousUrlDifferentFromThis(): bool
    {
        return $this->url->current() !== preg_replace('/\?.*/', '', $this->url->previous());
    }

    final protected function createJsonResponse(Throwable $throwable, array $metadata = []): JsonResponse
    {
        return response()->json(
            $this->transformToApplicationResponse($throwable, $metadata)->serialize(),
            HttpExceptionStatusCodeMapping::statusCodeFor($throwable)
        );
    }

    final protected function transformToApplicationResponse(Throwable $throwable, array $metadata): ErrorResponse
    {
        return $this->responseFactory->convertToErrorResponse($throwable, $this->nameParser, $metadata);
    }

    protected function meta(): callable
    {
        return static fn(Throwable $exception): array => [];
    }
}
