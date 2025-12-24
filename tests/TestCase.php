<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Tests;

use Vaened\Laravception\Decoders\SnakeCaseExceptionNameParser;
use Vaened\Laravception\Exceptions\TranslatableException;
use Vaened\Laravception\Handlers\ThrowableHandler;
use Vaened\Laravception\Handlers\ValidationExceptionHandler;
use Vaened\Laravception\HttpExceptionStatusCodeMapping;
use Vaened\Laravception\LaravceptionConfig;

abstract class TestCase extends UnitTestCase
{
    private ?LaravceptionConfig $config = null;

    protected function setUp(): void
    {
        parent::setUp();
        //     BypassFinals::enable();
    }

    public function config(): LaravceptionConfig
    {
        return $this->config ??= new LaravceptionConfig([
            'decode'         => 'snake_case',
            'decoders'       => [
                'snake_case' => SnakeCaseExceptionNameParser::class,
            ],
            'translations'   => [
                TranslatableException::class => 'exceptions',
            ],
            'handlers'       => [
                ValidationExceptionHandler::class,
                ThrowableHandler::class,
            ],
            'code_mapper'    => HttpExceptionStatusCodeMapping::class,
            'classification' => [
                'property' => 'tags',
            ]
        ]);
    }
}