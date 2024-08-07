<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Decoders;

use Illuminate\Support\Str;
use Throwable;

use function class_basename;

final readonly class SnakeCaseExceptionNameParser implements ExceptionNameParser
{
    public function parse(Throwable $throwable): string
    {
        return Str::snake(class_basename($throwable));
    }
}
