<?php
/**
 * @author enea dhack <contact@vaened.dev>
 * @link https://vaened.dev DevFolio
 */

declare(strict_types=1);

namespace Vaened\Laravception\Tests\Handlers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Vaened\Laravception\Handlers\ErrorHandler;

final class CustomHandler extends ErrorHandler
{
    public function __invoke(Throwable $exception, Request $request): ?Response
    {
        return $this->createJsonResponse($exception);
    }
}
