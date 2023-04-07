<?php

namespace ArtARTs36\ContextLogger;

use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\ContextLogger\Store\ApcStore;
use ArtARTs36\ContextLogger\Store\ApcuStore;
use ArtARTs36\ContextLogger\Store\MemoryStore;
use ArtARTs36\ContextLogger\Store\NullStore;
use ArtARTs36\ContextLogger\Store\StoreUnavailableException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class LoggerFactory
{
    public static function wrapInMemory(LoggerInterface $logger): ContextLogger
    {
        return new Logger(
            $logger,
            new MemoryStore(),
        );
    }

    /**
     * @throws StoreUnavailableException
     */
    public static function wrapInApcu(LoggerInterface $logger): ContextLogger
    {
        return new Logger($logger, ApcuStore::create());
    }

    /**
     * @throws StoreUnavailableException
     */
    public static function wrapInApc(LoggerInterface $logger): ContextLogger
    {
        return new Logger($logger, ApcStore::create());
    }

    public static function wrapWithoutContext(LoggerInterface $logger): ContextLogger
    {
        return new Logger($logger, new NullStore());
    }

    public static function null(): ContextLogger
    {
        return self::wrapWithoutContext(new NullLogger());
    }
}
