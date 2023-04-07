<?php

namespace ArtARTs36\ContextLogger\Tests\Unit\Store;

use ArtARTs36\ContextLogger\Store\MemoryStore;
use ArtARTs36\ContextLogger\Tests\TestCase;

final class MemoryStoreTest extends TestCase
{
    /**
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::put
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::all
     */
    public function testPut(): void
    {
        $store = new MemoryStore();

        $store->put('test_key1', 'test_value1');

        self::assertEquals(['test_key1' => 'test_value1'], $store->all());
    }

    /**
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::clear
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::all
     */
    public function testClear(): void
    {
        $store = new MemoryStore([
            'test_key1' => 'test_value1',
            'test_key2' => 'test_value2',
        ]);

        $store->clear('test_key1');

        self::assertEquals(['test_key2' => 'test_value2'], $store->all());
    }
}
