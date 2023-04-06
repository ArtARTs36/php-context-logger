<?php

namespace ArtARTs36\ContextLogger;

use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\ContextLogger\Store\ApcuStore;
use ArtARTs36\ContextLogger\Store\MemoryStore;
use ArtARTs36\ContextLogger\Store\NullStore;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class Logger
{
    public static function wrapInMemory(LoggerInterface $logger): ContextLogger
    {
        return new StoreLogger(
            $logger,
            new MemoryStore(),
        );
    }

    public static function wrapInApcu(LoggerInterface $logger): ContextLogger
    {
        return new StoreLogger($logger, ApcuStore::create());
    }

    public static function wrapWithoutContext(LoggerInterface $logger): ContextLogger
    {
        return new StoreLogger($logger, new NullStore());
    }

    public static function null(): ContextLogger
    {
        return self::wrapWithoutContext(new NullLogger());
    }
}
