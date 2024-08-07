<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception;

use Illuminate\Contracts\Translation\Translator;
use Throwable;
use Vaened\Laravception\Decoders\ExceptionNameParser;
use Vaened\Laravception\Exceptions\Codeable;
use Vaened\Laravception\Exceptions\Parametrizable;
use Vaened\Laravception\Exceptions\TranslatableException;

final readonly class ExceptionTranslator
{
    public function __construct(
        private Translator                    $translator,
        private ExceptionNameParser           $nameParser,
        private TranslationRepositoryResolver $pathResolver
    )
    {
    }

    public function translate(TranslatableException $throwable): ?string
    {
        $source            = $this->repositoryOf($throwable);
        $translatedMessage = $this->translator->get($source, $this->getParametersIfHave($throwable));

        return $translatedMessage === $source
            ? null
            : $translatedMessage;
    }

    private function repositoryOf(Throwable $throwable): string
    {
        $source = $this->messageSourceOf($throwable);
        $code   = $this->errorCodeFrom($throwable);

        return "$source.$code";
    }

    private function getParametersIfHave(Throwable $throwable): array
    {
        return $throwable instanceof Parametrizable ? $throwable->parameters() : [];
    }

    private function messageSourceOf(Throwable $throwable): string
    {
        return $this->pathResolver->repository($throwable);
    }

    private function errorCodeFrom(Throwable $throwable): ?string
    {
        return $throwable instanceof Codeable
            ? $throwable->errorCode()
            : $this->nameParser->parse($throwable);
    }
}
