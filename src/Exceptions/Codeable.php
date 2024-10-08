<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Exceptions;

interface Codeable
{
    public function errorCode(): string;
}
