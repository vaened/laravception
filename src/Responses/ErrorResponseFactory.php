<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Responses;

use Illuminate\Support\Facades\App;
use Vaened\Laravception\LaravceptionConfig;

use function resolve;

final readonly class ErrorResponseFactory
{
    public function __construct(private LaravceptionConfig $config)
    {
    }

    public function convertToErrorResponse(): ErrorResponse
    {
        return App::environment('production')
            ? resolve($this->config->productionResponse())
            : resolve($this->config->developmentResponse());
    }
}
