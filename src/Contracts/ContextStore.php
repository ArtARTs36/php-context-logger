<?php

namespace ArtARTs36\ContextLogger\Contracts;

use ArtARTs36\ContextLogger\Store\FetchContextException;

/**
 * Interface for different context stores.
 * @phpstan-type Context = array<string, mixed>
 */
interface ContextStore
{
    /**
     * Put context value by key.
     */
    public function put(string $key, mixed $value): void;

    /**
     * Get all context values.
     * @return Context
     * @throws FetchContextException
     */
    public function all(): array;

    /**
     * Clear context value by key.
     */
    public function clear(string $key): void;

    /**
     * Flush context.
     */
    public function flush(): void;
}
