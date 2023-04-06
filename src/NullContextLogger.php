<?php

namespace ArtARTs36\ContextLogger;

use Psr\Log\LoggerTrait;

final class NullContextLogger implements ContextLogger
{
    use LoggerTrait;

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        //
    }

    public function shareContext(string $key, mixed $value): void
    {
        //
    }

    public function clearContext(string $key): void
    {
        //
    }
}
