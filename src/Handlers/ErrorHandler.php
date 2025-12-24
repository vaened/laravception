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
use Vaened\Laravception\HttpExceptionStatusCodeMapping;
use Vaened\Laravception\LaravceptionConfig;
use Vaened\Laravception\Responses\ErrorResponse;
use Vaened\Laravception\Responses\ErrorResponseFactory;
use Vaened\Laravception\Responses\ErrorTagger;

abstract class ErrorHandler
{
    public function __construct(
        private readonly UrlGenerator         $url,
        private readonly ErrorTagger          $tagger,
        private readonly LaravceptionConfig   $config,
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
        $response = $this->transformToApplicationResponse()
                         ->serialize($throwable, $metadata);

        if ($this->config->isClassificationEnabled()) {
            $property            = $this->config->classificationProperty();
            $response[$property] = $this->tagger->classify($throwable);
        }

        return response()->json(
            $response,
            HttpExceptionStatusCodeMapping::statusCodeFor($throwable)
        );
    }

    final protected function transformToApplicationResponse(): ErrorResponse
    {
        return $this->responseFactory->convertToErrorResponse();
    }

    protected function meta(): callable
    {
        return static fn(Throwable $exception): array => [];
    }
}
