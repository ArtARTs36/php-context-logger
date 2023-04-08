<?php

namespace ArtARTs36\ContextLogger\Contracts;

use ArtARTs36\ContextLogger\Store\File\FileNotFoundException;

/**
 * Interface for Lockable Files.
 */
interface LockableFile
{
    /**
     * Get file path.
     */
    public function path(): string;

    /**
     * Check file exists.
     */
    public function exists(): bool;

    /**
     * Write contents to file.
     */
    public function write(string $contents): void;

    /**
     * Read file content.
     * @throws FileNotFoundException
     */
    public function read(): string;
}
