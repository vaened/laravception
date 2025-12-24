<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Responses;

use Illuminate\Support\Arr;
use Throwable;
use Vaened\Laravception\Decoders\ExceptionNameParser;

use function get_class;
use function Lambdish\Phunctional\map;

final readonly class DevelopmentJsonResponse implements ErrorResponse
{
    public function __construct(
        private ExceptionNameParser $nameParser,
    )
    {
    }

    public function serialize(Throwable $throwable, array $metadata): array
    {
        $response = new ProductionJsonResponse($this->nameParser);

        return [
            ...$response->serialize($throwable, $metadata),
            ...$this->convertExceptionToArray($throwable),
        ];
    }

    protected function convertExceptionToArray(Throwable $throwable): array
    {
        return [
            'exception' => get_class($throwable),
            'file'      => $throwable->getFile(),
            'line'      => $throwable->getLine(),
            'trace'     => map(
                static fn($trace) => Arr::except($trace, ['args']),
                $throwable->getTrace()
            ),
        ];
    }
}
