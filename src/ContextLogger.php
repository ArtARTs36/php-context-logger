<?php

namespace ArtARTs36\ContextLogger;

use Psr\Log\LoggerInterface;

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
