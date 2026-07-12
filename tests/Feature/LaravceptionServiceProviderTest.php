<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Tests\Feature;

use Illuminate\Foundation\Exceptions\Handler;
use PHPUnit\Framework\Attributes\Test;
use Vaened\Laravception\Decoders\ExceptionNameParser;
use Vaened\Laravception\LaravceptionConfig;
use Vaened\Laravception\Tests\UnitTestCase;

final class LaravceptionServiceProviderTest extends UnitTestCase
{
    #[Test]
    public function service_provider_registers_main_bindings(): void
    {
        $this->assertInstanceOf(LaravceptionConfig::class, $this->app->make(LaravceptionConfig::class));
        $this->assertInstanceOf(ExceptionNameParser::class, $this->app->make(ExceptionNameParser::class));
    }

    #[Test]
    public function exception_handler_can_be_resolved_after_package_registration(): void
    {
        $this->assertInstanceOf(Handler::class, $this->app->make(Handler::class));
    }
}
