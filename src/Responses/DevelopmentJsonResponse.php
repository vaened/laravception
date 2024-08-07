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
    private ProductionJsonResponse $response;

    public function __construct(
        private Throwable   $throwable,
        ExceptionNameParser $nameParser,
        array               $metadata
    )
    {
        $this->response = new ProductionJsonResponse($throwable, $nameParser, $metadata);
    }

    public function serialize(): array
    {
        return [
            ...$this->response->serialize(),
            ...$this->convertExceptionToArray($this->throwable),
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
