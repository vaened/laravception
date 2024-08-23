<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception;

use Illuminate\Foundation\Exceptions\Handler;
use Throwable;
use Vaened\Laravception\Exceptions\TranslatableException;
use Vaened\Laravception\Reporter\ExceptionTranslatorReporter;

use function Lambdish\Phunctional\apply;
use function Lambdish\Phunctional\each;
use function resolve;

final readonly class Configurator
{
    public function __construct(private LaravceptionConfig $config)
    {
    }

    public function __invoke(Handler $handler): void
    {
        $handler->reportable(static function (TranslatableException $exception): Throwable {
            return apply(
                resolve(ExceptionTranslatorReporter::class),
                [$exception]
            );
        });

        each(
            static fn(string $drive) => $handler->renderable(resolve($drive)),
            $this->config->handlers()
        );
    }
}
