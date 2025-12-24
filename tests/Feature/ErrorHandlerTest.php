<?php
/**
 * @author enea dhack <contact@vaened.dev>
 * @link https://vaened.dev DevFolio
 */

declare(strict_types=1);

namespace Vaened\Laravception\Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Throwable;
use Vaened\Laravception\Responses\ErrorResponse;
use Vaened\Laravception\Responses\ErrorResponseFactory;
use Vaened\Laravception\Responses\ErrorTagger;
use Vaened\Laravception\Tests\Exceptions\PersonNotExistsDomainException;
use Vaened\Laravception\Tests\Handlers\CustomHandler;
use Vaened\Laravception\Tests\TestCase;

use function json_encode;

final class ErrorHandlerTest extends TestCase
{
    private readonly CustomHandler                      $handler;

    private readonly ErrorResponseFactory|MockInterface $errorResponseFactory;

    private readonly Request|MockInterface              $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->errorResponseFactory = self::create(ErrorResponseFactory::class);
        $this->request              = self::create(Request::class);

        $this->handler = new CustomHandler(
            self::create(UrlGenerator::class),
            new ErrorTagger(),
            $this->config(),
            $this->errorResponseFactory,
        );
    }

    #[Test]
    public function check_correct_structure(): void
    {
        $exception           = new PersonNotExistsDomainException("019b5257-0d2f-76a8-8ebb-0a291b897d13");
        $customErrorResponse = self::customErrorResponse();
        $this->errorResponseFactory->shouldReceive('convertToErrorResponse')
                                   ->once()
                                   ->andReturn($customErrorResponse);

        $response = $this->handler->__invoke($exception, $this->request);

        $this->assertJson($response->getContent(), json_encode([
            'exception' => PersonNotExistsDomainException::class,
            'metadata'  => [],
            'tags'      => ['codeable', 'translated', 'parametrized']
        ]));
    }

    private static function customErrorResponse(): ErrorResponse
    {
        return new class implements ErrorResponse {
            public function serialize(Throwable $throwable, array $metadata): array
            {
                return [
                    'exception' => get_class($throwable),
                    'metadata'  => $metadata,
                ];
            }
        };
    }
}
