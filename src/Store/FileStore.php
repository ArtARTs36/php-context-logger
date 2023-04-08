<?php

namespace ArtARTs36\ContextLogger\Store;

use ArtARTs36\ContextLogger\Contracts\ContextStore;
use ArtARTs36\ContextLogger\Contracts\LockableFile;
use ArtARTs36\ContextLogger\Store\File\FileLockNotAcquiredException;
use ArtARTs36\ContextLogger\Store\File\FileNotFoundException;
use ArtARTs36\ContextLogger\Store\File\LockFile;

final class FileStore implements ContextStore
{
    public function __construct(
        private readonly LockableFile $file,
    ) {
        //
    }

    public static function create(string $filepath): self
    {
        return new self(new LockFile($filepath));
    }

    public function all(): array
    {
        if (! $this->file->exists()) {
            return [];
        }

        try {
            $val = $this->file->read();
        } catch (FileLockNotAcquiredException|FileNotFoundException $e) {
            throw new FetchContextException($e->getMessage(), previous: $e);
        }

        if ($val === '') {
            return [];
        }

        $val = unserialize($val);

        if (! is_array($val)) {
            throw new FetchContextException(sprintf('File "%s" contains no array serialized value', $this->file->path()));
        }

        return $val;
    }

    public function put(string $key, mixed $value): void
    {
        $context = $this->all();

        $context[$key] = $value;

        $this->file->write(serialize($context));
    }

    public function clear(string $key): void
    {
        $context = $this->all();

        if (empty($context)) {
            return;
        }

        unset($context[$key]);

        $this->file->write(serialize($context));
    }
}
