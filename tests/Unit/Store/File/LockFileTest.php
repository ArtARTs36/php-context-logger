<?php

namespace ArtARTs36\ContextLogger\Tests\Unit\Store\File;

use ArtARTs36\ContextLogger\Store\File\FileNotFoundException;
use ArtARTs36\ContextLogger\Store\File\LockFile;
use ArtARTs36\ContextLogger\Tests\TestCase;

final class LockFileTest extends TestCase
{
    /**
     * @covers \ArtARTs36\ContextLogger\Store\File\LockFile::write
     */
    public function testWrite(): void
    {
        $file = new LockFile('t.txt');

        $file->write('test');

        self::assertFileExists('t.txt');
        self::assertEquals('test', file_get_contents('t.txt'));

        $file->delete();
    }

    /**
     * @covers \ArtARTs36\ContextLogger\Store\File\LockFile::read
     */
    public function testReadOnFileNonExists(): void
    {
        $file = new LockFile('t.txt');

        self::expectException(FileNotFoundException::class);

        $file->read();
    }
}
