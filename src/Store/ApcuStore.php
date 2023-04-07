<?php

namespace ArtARTs36\ContextLogger\Store;

use ArtARTs36\ContextLogger\Contracts\ContextStore;

/**
 * @phpstan-import-type Context from ContextStore
 */
final class ApcuStore implements ContextStore
{
    private const KEY = 'context_logger.shared_context';

    private function __construct()
    {
        //
    }

    /**
     * @param Context $initial
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

    /**
     * @param Context $values
     */
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

        if ($val === false) {
            return [];
        }

        if (! is_array($val)) {
            throw new FetchContextException(sprintf('apc_fetch returns no array value by key "%s"', self::KEY));
        }

        return $val;
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

    /**
     * @param Context $context
     */
    private function set(array $context): void
    {
        apcu_store(self::KEY, $context);
    }
}
