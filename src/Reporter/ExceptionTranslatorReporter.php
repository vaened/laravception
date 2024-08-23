<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Reporter;

use ReflectionClass;
use Throwable;
use Vaened\Laravception\Exceptions\TranslatableException;
use Vaened\Laravception\ExceptionTranslator;

final readonly class ExceptionTranslatorReporter
{
    public function __construct(
        private ExceptionTranslator $translator
    )
    {
    }

    public function __invoke(TranslatableException $exception): Throwable
    {
        $message = $this->translator->translate($exception);

        if (null !== $message) {
            (new ReflectionClass($exception))
                ->getProperty('message')
                ->setValue($exception, $message);

            unset($reflection);
        }

        return $exception;
    }
}
