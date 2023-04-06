<?php

namespace ArtARTs36\ContextLogger\Contracts;

interface ContextStore
{
    public function put(string $key, mixed $value): void;

    /**
     * @return array<string, mixed>
     */
    public function all(): array;

    public function clear(string $key): void;
}
