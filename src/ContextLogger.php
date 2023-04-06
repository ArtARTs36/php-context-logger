<?php

namespace ArtARTs36\ContextLogger;

interface ContextLogger
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
