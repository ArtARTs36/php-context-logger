<?php

namespace ArtARTs36\ContextLogger;

use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\ContextLogger\Store\ApcuStore;
use ArtARTs36\ContextLogger\Store\FileStore;
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

    public static function wrapInFile(LoggerInterface $logger, string $filepath): ContextLogger
    {
        return new Logger($logger, FileStore::create($filepath));
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
