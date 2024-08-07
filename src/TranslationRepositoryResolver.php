<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception;

use Throwable;

use function is_a;
use function Lambdish\Phunctional\search;

class TranslationRepositoryResolver
{
    private const DEFAULT_REPOSITORY = 'exceptions';

    public function __construct(private readonly LaravceptionConfig $config)
    {
    }

    public function repository(Throwable $exception): string
    {
        $repositories = $this->config->repositories();
        $repository   = search(
            static fn(string $repository, string $class) => is_a($exception, $class),
            $repositories
        );

        return $repository ?? self::DEFAULT_REPOSITORY;
    }
}
