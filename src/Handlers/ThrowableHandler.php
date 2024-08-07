<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Handlers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ThrowableHandler extends ErrorHandler
{
    public function __invoke(Throwable $exception, Request $request): ?Response
    {
        if ($this->shouldReturnJson($request)) {
            return $this->createJsonResponse($exception);
        }

        return null;
    }
}
