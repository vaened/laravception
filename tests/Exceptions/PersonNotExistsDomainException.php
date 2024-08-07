<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Tests\Exceptions;

use RuntimeException;
use Vaened\Laravception\Exceptions\Codeable;
use Vaened\Laravception\Exceptions\Parametrizable;
use Vaened\Laravception\Exceptions\TranslatableException;

final class PersonNotExistsDomainException extends RuntimeException implements TranslatableException, Codeable, Parametrizable
{
    public function __construct(private readonly string $personId)
    {
        parent::__construct("Person with id <$personId> not exists");
    }

    public function errorCode(): string
    {
        return 'person.not_exists';
    }

    public function parameters(): array
    {
        return [
            'id' => $this->personId,
        ];
    }
}