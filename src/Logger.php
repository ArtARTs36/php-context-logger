<?php

namespace ArtARTs36\ContextLogger;

use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\ContextLogger\Contracts\ContextStore;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

final class Logger implements ContextLogger
{
    use LoggerTrait;

    /** @var array<string, mixed> */
    private array $context = [];

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ContextStore $store,
    ) {
        //
    }

    public function shareContext(string $key, mixed $value): void
    {
        $this->store->put($key, $value);
    }

    public function clearContext(string $key): void
    {
        $this->store->clear($key);
    }

    public function log($level, $message, array $context = []): void
    {
        $this->logger->log($level, $message, array_merge($this->store->all(), $context));
    }
}
