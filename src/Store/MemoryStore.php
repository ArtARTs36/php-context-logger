<?php

namespace ArtARTs36\ContextLogger\Store;

use ArtARTs36\ContextLogger\Contracts\ContextStore;

class MemoryStore implements ContextStore
{
    public function __construct(
        private array $context = [],
    ) {
        //
    }

    public function put(string $key, mixed $value): void
    {
        $this->context[$key] = $value;
    }

    public function clear(string $key): void
    {
        unset($this->context[$key]);
    }

    public function all(): array
    {
        return $this->context;
    }
}
