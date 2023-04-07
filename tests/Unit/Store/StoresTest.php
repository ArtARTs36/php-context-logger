<?php

namespace ArtARTs36\ContextLogger\Tests\Unit\Store;

use ArtARTs36\ContextLogger\Contracts\ContextStore;
use ArtARTs36\ContextLogger\Store\ApcuStore;
use ArtARTs36\ContextLogger\Store\MemoryStore;
use ArtARTs36\ContextLogger\Tests\TestCase;

final class StoresTest extends TestCase
{
    public static function providerForTestPut(): array
    {
        return [
            [
                new MemoryStore(),
                'test_key1',
                'test_value1',
                ['test_key1' => 'test_value1'],
            ],
            [
                ApcuStore::create(),
                'test_key1',
                'test_value1',
                ['test_key1' => 'test_value1'],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::put
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::all
     * @covers \ArtARTs36\ContextLogger\Store\ApcuStore::put
     * @covers \ArtARTs36\ContextLogger\Store\ApcuStore::all
     * @dataProvider providerForTestPut
     */
    public function testPut(ContextStore $store, string $key, mixed $value, array $expected): void
    {
        $store->put($key, $value);

        self::assertEquals($expected, $store->all(), get_class($store) . ': Put failed on key ' . $key);
    }

    public static function providerForTestClear(): array
    {
        return [
            [
                new MemoryStore([
                    'test_key1' => 'test_value1',
                    'test_key2' => 'test_value2',
                ]),
                'test_key1',
                ['test_key2' => 'test_value2'],
            ],
            [
                ApcuStore::create([
                    'test_key1' => 'test_value1',
                    'test_key2' => 'test_value2',
                ]),
                'test_key1',
                ['test_key2' => 'test_value2'],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::clear
     * @covers \ArtARTs36\ContextLogger\Store\MemoryStore::all
     * @covers \ArtARTs36\ContextLogger\Store\ApcuStore::clear
     * @covers \ArtARTs36\ContextLogger\Store\ApcuStore::all
     * @dataProvider providerForTestClear
     */
    public function testClear(ContextStore $store, string $key, array $expected): void
    {
        $store->clear($key);

        self::assertEquals($expected, $store->all());
    }

    protected function tearDown(): void
    {
        ApcuStore::create()->truncate();
    }
}
