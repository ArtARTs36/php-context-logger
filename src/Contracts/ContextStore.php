<?php

namespace ArtARTs36\ContextLogger\Contracts;

use ArtARTs36\ContextLogger\Store\FetchContextException;

/**
 * @phpstan-type Context = array<string, mixed>
 */
interface ContextStore
{
    public function put(string $key, mixed $value): void;

    /**
     * @return Context
     * @throws FetchContextException
     */
    public function all(): array;

    public function clear(string $key): void;
}
