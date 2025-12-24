<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Responses;

use Throwable;

interface ErrorResponse
{
    public function serialize(Throwable $throwable, array $metadata): array;
}
