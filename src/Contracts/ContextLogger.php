<?php

namespace ArtARTs36\ContextLogger\Contracts;

use Psr\Log\LoggerInterface;

/**
 * Interface for Context Logger.
 */
interface ContextLogger extends LoggerInterface
{
    /**
     * Share log context.
     */
    public function shareContext(string $key, mixed $value): void;

    /**
     * Clear log context by key.
     */
    public function clearContext(string $key): void;
}
