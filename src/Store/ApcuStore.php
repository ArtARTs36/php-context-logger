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

    /**
     * @throws StoreUnavailableException
     */
    public static function create(): self
    {
        if (! function_exists('apcu_enabled') || ! apcu_enabled()) {
            throw new StoreUnavailableException('[ContextLogger] ApcuStore not available, because apcu not installed');
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
        $val = apcu_fetch(self::KEY);

        return $val === false ? [] : $val;
    }

    public function clear(string $key): void
    {
        $context = $this->all();

        unset($context[$key]);
    }

    public function truncate(): void
    {
        apcu_delete(self::KEY);
    }
}
