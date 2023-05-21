<?php

namespace ArtARTs36\ContextLogger\Store;

use ArtARTs36\ContextLogger\Contracts\ContextStore;

final class NullStore implements ContextStore
{
    public function put(string $key, mixed $value): void
    {
        //
    }

    public function all(): array
    {
        return [];
    }

    public function clear(string $key): void
    {
        //
    }

    public function flush(): void
    {
        //
    }
}
