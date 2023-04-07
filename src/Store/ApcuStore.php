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
    public static function create(array $initial = []): self
    {
        if (! function_exists('apcu_enabled') || ! apcu_enabled()) {
            throw new StoreUnavailableException('[ContextLogger] ApcuStore not available, because apcu not installed');
        }

        $instance = new self();
        $instance->putMany($initial);

        return $instance;
    }

    public function putMany(array $values): void
    {
        $context = $this->all();
        $context = array_merge($context, $values);

        $this->set($context);
    }

    public function put(string $key, mixed $value): void
    {
        $context = $this->all();

        $context[$key] = $value;

        $this->set($context);
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

        $this->set($context);
    }

    public function truncate(): void
    {
        apcu_delete(self::KEY);
    }

    private function set(array $context): void
    {
        apcu_store(self::KEY, $context);
    }
}
