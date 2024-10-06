<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Support\ServiceProvider;
use Vaened\Laravception\Decoders\ExceptionNameParser;

use function config;
use function config_path;
use function Lambdish\Phunctional\apply;
use function lang_path;
use function resolve;
use function sprintf;

final class LaravceptionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            LaravceptionConfig::class,
            static fn() => new LaravceptionConfig(config('laravception'))
        );

        $this->app->singleton(
            ExceptionNameParser::class,
            static function (Application $application) {
                $config = $application->make(LaravceptionConfig::class);
                return $application->make($config->decoder());
            }
        );

        $this->app->afterResolving(
            Handler::class,
            static function (Handler $handler) {
                apply(resolve(Configurator::class), [$handler]);
            },
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $locale = config('app.locale', 'es');

            $this->publishes([
                __DIR__ . '/../config/laravception.php' => config_path('laravception.php'),
                __DIR__ . '/../lang/exceptions.php'     => lang_path(sprintf('%s/exceptions.php', $locale)),
            ], 'laravception');
        }
    }
}
