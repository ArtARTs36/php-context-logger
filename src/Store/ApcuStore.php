<?php

namespace ArtARTs36\ContextLogger\Store;

use ArtARTs36\ContextLogger\Contracts\ContextStore;

final class ApcuStore implements ContextStore
{
    private const KEY = 'context_logger.shared_context';

    private function __construct()
    {
        //
    }

    public static function create(): self
    {
        if (! function_exists('apcu_enabled') || ! apcu_enabled()) {
            throw new \RuntimeException('[ContextLogger] ApcuStore not available, because apcu not installed');
        }

        return new self();
    }

    public function put(string $key, mixed $value): void
    {
        $context = $this->all();

        $context[$key] = $value;

        apcu_store(self::KEY, $context);
    }

    public function all(): array
    {
        return apcu_fetch(self::KEY);
    }

    public function clear(string $key): void
    {
        apcu_delete(self::KEY);
    }
}
