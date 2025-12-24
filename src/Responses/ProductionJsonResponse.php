<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Responses;

use Throwable;
use Vaened\Laravception\Decoders\ExceptionNameParser;
use Vaened\Laravception\Exceptions\Codeable;
use Vaened\Laravception\Exceptions\Parametrizable;

final readonly class ProductionJsonResponse implements ErrorResponse
{
    public function __construct(
        private ExceptionNameParser $nameParser,
    )
    {
    }

    public function serialize(Throwable $throwable, array $metadata): array
    {
        return [
            'code'    => self::exceptionCodeFor($throwable),
            'message' => $throwable->getMessage(),
            'params'  => self::exceptionParamsFrom($throwable),
            'meta'    => $metadata
        ];
    }

    protected function exceptionCodeFor(Throwable $throwable): string
    {
        return $throwable instanceof Codeable ? $throwable->errorCode() : $this->nameParser->parse($throwable);
    }

    private static function exceptionParamsFrom(Throwable $throwable): array
    {
        return $throwable instanceof Parametrizable ? $throwable->parameters() : [];
    }
}
