<?php

namespace ArtARTs36\ContextLogger\Tests\Mocks;

use ArtARTs36\ContextLogger\Contracts\LockableFile;
use PHPUnit\Framework\Assert;

final class MockLockableFile implements LockableFile
{
    private bool $changed = false;

    public function __construct(
        private readonly string $path = '',
        private bool $exists = false,
        public string $content = '',
    ) {
        //
    }

    public function path(): string
    {
        return $this->path;
    }

    public function exists(): bool
    {
        return $this->exists;
    }

    public function write(string $contents): void
    {
        $this->content = $contents;
        $this->exists = true;
        $this->changed = true;
    }

    public function read(): string
    {
        return $this->content;
    }

    public function assertNonExists(): void
    {
        Assert::assertFalse($this->exists, sprintf(
            'File "%s" exists',
            $this->path,
        ));
    }

    public function assertNotChanged(): void
    {
        Assert::assertFalse($this->changed, sprintf(
            'File "%s" has changes',
            $this->path,
        ));
    }

    public function assertContentEquals(string $expected): void
    {
        Assert::assertEquals($expected, $this->content);
    }
}
