<?php

namespace ArtARTs36\ContextLogger\Store\File;

/**
 * @phpstan-type FileResource = resource
 */
class LockFile
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

    /**
     * @throws FileNotFoundException
     */
    private function open(): void
    {
        $handle = fopen($this->path, 'rb');

        if ($handle === false) {
            throw new FileNotFoundException(sprintf('File with path "%s" not found', $this->path));
        }

        $this->fileHandle = $handle;
    }

    private function close(): void
    {
        fclose($this->fileHandle);
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
