<?php

namespace ArtARTs36\ContextLogger\Tests\Unit\Store;

use ArtARTs36\ContextLogger\Store\MemoryStore;
use ArtARTs36\ContextLogger\Tests\TestCase;

final class MemoryStoreTest extends TestCase
{
    public static function providerForTestPut(): array
    {
        return [
            [
                [],
                'test_key1',
                'test_value1',
                ['test_key1' => 'test_value1'],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::put
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::all
     * @dataProvider providerForTestPut
     */
    public function testPut(array $initial, string $key, mixed $value, array $expected): void
    {
        $store = new MemoryStore($initial);

        $store->put($key, $value);

        self::assertEquals($expected, $store->all(), get_class($store) . ': Put failed on key ' . $key);
    }

    public static function providerForTestClear(): array
    {
        return [
            [
                [
                    'test_key1' => 'test_value1',
                    'test_key2' => 'test_value2',
                ],
                'test_key1',
                ['test_key2' => 'test_value2'],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::clear
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::all
     * @dataProvider providerForTestClear
     */
    public function testClear(array $initial, string $key, array $expected): void
    {
        $store = new MemoryStore($initial);

        $store->clear($key);

        self::assertEquals($expected, $store->all());
    }
}
