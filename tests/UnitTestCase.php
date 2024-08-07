<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Tests;

use Mockery;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class UnitTestCase extends Orchestra
{
    /**
     * @template T
     * @param class-string<T> $className
     *
     * @return MockInterface|T
     */
    protected static function create(mixed $className): mixed
    {
        return Mockery::mock($className);
    }
}