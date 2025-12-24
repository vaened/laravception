<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception;

use Vaened\Laravception\Responses\DevelopmentJsonResponse;
use Vaened\Laravception\Responses\ProductionJsonResponse;

final readonly class LaravceptionConfig
{
    public function __construct(private array $config)
    {
    }

    public function rootException(): string
    {
        return $this->config['root'];
    }

    public function developmentResponse(): string
    {
        return $this->config['responses']['development'] ?? DevelopmentJsonResponse::class;
    }

    public function productionResponse(): string
    {
        return $this->config['responses']['production'] ?? ProductionJsonResponse::class;
    }

    public function decode(): string
    {
        return $this->config['decode'];
    }

    public function decoder(): string
    {
        return $this->config['decoders'][$this->decode()];
    }

    public function repositories(): array
    {
        return $this->config['translations'] ?? [];
    }

    public function handlers(): array
    {
        return $this->config['handlers'] ?? [];
    }

    public function codeMapper(): string
    {
        return $this->config['code_mapper'];
    }
}
