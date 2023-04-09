<?php

namespace ArtARTs36\ContextLogger\Tests\Unit\Store;

use ArtARTs36\ContextLogger\Store\FileStore;
use ArtARTs36\ContextLogger\Tests\Mocks\MockLockableFile;
use ArtARTs36\ContextLogger\Tests\TestCase;

final class FileStoreTest extends TestCase
{
    /**
     * @covers \ArtARTs36\ContextLogger\Store\FileStore::clear
     */
    public function testClearOnFileNonExists(): void
    {
        $file = new MockLockableFile();

        $store = new FileStore($file);

        $store->clear('k1');

        $file->assertNonExists();
    }

    /**
     * @covers \ArtARTs36\ContextLogger\Store\FileStore::clear
     */
    public function testClear(): void
    {
        $file = new MockLockableFile(
            exists: true,
            content: serialize([
                'k1' => 'v1',
                'k2' => 'v2',
            ]),
        );

        $store = new FileStore($file);

        $store->clear('k2');

        $file->assertContentEquals(serialize([
            'k1' => 'v1',
        ]));
    }

    /**
     * @covers \ArtARTs36\ContextLogger\Store\FileStore::put
     */
    public function testPutOnFileNonExists(): void
    {
        $file = new MockLockableFile();

        $store = new FileStore($file);

        $store->put('k1', 'v1');

        $file->assertContentEquals(serialize([
            'k1' => 'v1',
        ]));
    }

    /**
     * @covers \ArtARTs36\ContextLogger\Store\FileStore::all
     */
    public function testAllOnFileOnFileNonExists(): void
    {
        $file = new MockLockableFile();

        $store = new FileStore($file);

        self::assertEquals([], $store->all());
    }

    /**
     * @covers \ArtARTs36\ContextLogger\Store\FileStore::all
     */
    public function testAll(): void
    {
        $file = new MockLockableFile(exists: true, content: serialize([
            'k1' => 'v1',
        ]));

        $store = new FileStore($file);

        self::assertEquals(['k1' => 'v1'], $store->all());
    }
}
