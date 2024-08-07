<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Tests\Unit;

use Illuminate\Contracts\Translation\Translator;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Vaened\Laravception\Decoders\ExceptionNameParser;
use Vaened\Laravception\ExceptionTranslator;
use Vaened\Laravception\Tests\Exceptions\ComponentNotExistsException;
use Vaened\Laravception\Tests\Exceptions\PersonNotExistsDomainException;
use Vaened\Laravception\Tests\UnitTestCase;
use Vaened\Laravception\TranslationRepositoryResolver;

final class ExceptionTranslatorTest extends UnitTestCase
{
    private readonly Translator|MockInterface                    $translator;

    private readonly ExceptionNameParser|MockInterface           $nameParser;

    private readonly TranslationRepositoryResolver|MockInterface $repositoryResolver;

    private readonly ExceptionTranslator|MockInterface           $exceptionTranslator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->translator          = self::create(Translator::class);
        $this->nameParser          = self::create(ExceptionNameParser::class);
        $this->repositoryResolver  = self::create(TranslationRepositoryResolver::class);
        $this->exceptionTranslator = new ExceptionTranslator($this->translator, $this->nameParser, $this->repositoryResolver);
    }

    #[Test]
    public function strongly_typed_exception_has_been_translated(): void
    {
        $exception = new PersonNotExistsDomainException('7a8af1f7-f77f-4971-b1ef-6dfaa86935da');

        $this->nameParser->shouldNotReceive();

        $this->repositoryResolver
            ->shouldReceive('repository')
            ->with($exception)
            ->once()
            ->andReturn('exceptions');

        $this->translator
            ->shouldReceive('get')
            ->withArgs(['exceptions.person.not_exists', ['id' => '7a8af1f7-f77f-4971-b1ef-6dfaa86935da']])
            ->once()
            ->andReturn('La persona con identificación <7a8af1f7-f77f-4971-b1ef-6dfaa86935da> no existe.');

        $this->exceptionTranslator->translate($exception);
    }

    #[Test]
    public function weakly_Typed_Exception_has_been_translated(): void
    {
        $exception = new ComponentNotExistsException('component not exists');

        $this->nameParser
            ->shouldReceive('parse')
            ->with($exception)
            ->once()
            ->andReturn('component_not_exists');

        $this->repositoryResolver
            ->shouldReceive('repository')
            ->with($exception)
            ->once()
            ->andReturn('exceptions');

        $this->translator
            ->shouldReceive('get')
            ->withArgs(['exceptions.component_not_exists', []])
            ->once()
            ->andReturn('El componente no existe');

        $this->exceptionTranslator->translate($exception);
    }
}