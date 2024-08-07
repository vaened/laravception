<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

final class ValidationExceptionHandler extends ErrorHandler
{
    protected array $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function __invoke(ValidationException $exception, Request $request): ?Response
    {
        if (
            !$this->shouldReturnJson($request) &&
            $this->isPreviousUrlDifferentFromThis()
        ) {
            return $this->redirectBack($exception, $request);
        }

        return $this->createJsonResponse($exception, $exception->errors());
    }

    private function redirectBack(ValidationException $exception, Request $request): Response
    {
        return redirect($exception->redirectTo)
            ->withInput(Arr::except($request->input(), $this->dontFlash))
            ->withErrors($exception->errors(), $request->input('_error_bag', $exception->errorBag));
    }
}
