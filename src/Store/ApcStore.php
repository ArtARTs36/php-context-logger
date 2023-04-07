<?php

namespace ArtARTs36\ContextLogger\Store;

use ArtARTs36\ContextLogger\Contracts\ContextStore;

final class ApcStore implements ContextStore
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
        if (! extension_loaded('apc')) {
            throw new StoreUnavailableException('[ContextLogger] ApcStore not available, because apc not installed');
        }

        return new self();
    }

    public function put(string $key, mixed $value): void
    {
        $context = $this->all();

        $context[$key] = $value;

        $this->set($context);
    }

    public function all(): array
    {
        $val = apc_fetch(self::KEY);

        return $val === false ? [] : $val;
    }

    public function clear(string $key): void
    {
        $context = $this->all();

        unset($context[$key]);

        $this->set($context);
    }

    private function set(array $context): void
    {
        apcu_store(self::KEY, $context);
    }
}
