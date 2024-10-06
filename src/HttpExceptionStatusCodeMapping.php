<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception;

use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class HttpExceptionStatusCodeMapping implements ExceptionStatusCodeMapping
{
    private const DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    private array $exceptions = [
        InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
        ValidationException::class      => Response::HTTP_UNPROCESSABLE_ENTITY,
    ];

    public function register(string $exceptionClass, int $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }

    public function statusCodeFor(Throwable $throwable): int
    {
        return $this->exceptions[$throwable::class] ?? self::DEFAULT_STATUS_CODE;
    }
}
