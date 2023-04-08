<?php

namespace ArtARTs36\ContextLogger\Store\File;

use ArtARTs36\ContextLogger\Contracts\LockableFile;

/**
 * @phpstan-type FileResource = resource
 */
class LockFile implements LockableFile
{
    /** @var FileResource */
    private $fileHandle;

    public function __construct(
        private readonly string $path,
    ) {
        //
    }

    public function path(): string
    {
        return $this->path;
    }

    public function exists(): bool
    {
        return file_exists($this->path);
    }

    public function write(string $contents): void
    {
        file_put_contents($this->path, $contents, LOCK_EX);
    }

    /**
     * @throws FileNotFoundException
     */
    public function read(): string
    {
        try {
            $this->open();

            $this->acquireLock();

            clearstatcache(true, $this->path);

            $size = $this->size();

            if ($size === null) {
                throw new FileNotFoundException(sprintf('File with path "%s" not found', $this->path));
            }

            if ($size < 1) {
                return '';
            }

            $contents = fread($this->fileHandle, $size);

            if ($contents === false) {
                return '';
            }

            $this->freeLock();

            return $contents;
        } finally {
            $this->close();
        }
    }

    public function delete(): void
    {
        unlink($this->path);
    }

    /**
     * @throws FileNotFoundException
     */
    private function open(): void
    {
        $errorMsg = null;

        set_error_handler(function (int $l, string $message, string $el, int $ec) use (&$errorMsg) {
            $errorMsg = $message;

            return true;
        });

        $handle = fopen($this->path, 'rb');

        restore_error_handler();

        if ($errorMsg !== null) {
            throw new FileNotFoundException($errorMsg);
        }

        if ($handle === false) {
            throw new FileNotFoundException(sprintf('File with path "%s" not found', $this->path));
        }

        $this->fileHandle = $handle;
    }

    private function close(): void
    {
        if (is_resource($this->fileHandle)) {
            fclose($this->fileHandle);
        }
    }

    /**
     * @throws FileLockNotAcquiredException
     */
    private function acquireLock(): void
    {
        $lock = flock($this->fileHandle, LOCK_SH);

        if (! $lock) {
            throw new FileLockNotAcquiredException(sprintf('Lock for file "%s" not acquired', $this->path));
        }
    }

    private function freeLock(): void
    {
        flock($this->fileHandle, LOCK_UN);
    }

    private function size(): ?int
    {
        $size = filesize($this->path);

        return $size === false ? null : $size;
    }
}
