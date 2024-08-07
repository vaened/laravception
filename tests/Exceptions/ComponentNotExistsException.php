<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Tests\Exceptions;

use RuntimeException;
use Vaened\Laravception\Exceptions\TranslatableException;

final class ComponentNotExistsException extends RuntimeException implements TranslatableException
{
}