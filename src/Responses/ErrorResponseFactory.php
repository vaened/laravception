<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Responses;

use Illuminate\Support\Facades\App;
use Throwable;
use Vaened\Laravception\Decoders\ExceptionNameParser;

final class ErrorResponseFactory
{
    public function convertToErrorResponse(Throwable $throwable, ExceptionNameParser $nameParser, array $metadata): ErrorResponse
    {
        return App::environment('production')
            ? new ProductionJsonResponse($throwable, $nameParser, $metadata)
            : new DevelopmentJsonResponse($throwable, $nameParser, $metadata);
    }
}
