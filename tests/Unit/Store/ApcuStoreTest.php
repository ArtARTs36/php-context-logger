<?php

namespace ArtARTs36\ContextLogger\Tests\Unit\Store;

use ArtARTs36\ContextLogger\Store\ApcuStore;
use ArtARTs36\ContextLogger\Tests\TestCase;

final class ApcuStoreTest extends TestCase
{
    /**
     * @covers \ArtARTs36\ContextLogger\Store\ApcuStore::put
     * @covers \ArtARTs36\ContextLogger\Store\ApcuStore::all
     */
    public function testPut(): void
    {
        $store = ApcuStore::create();

        $store->put('test_key1', 'test_value1');

        self::assertEquals(['test_key1' => 'test_value1'], $store->all());
    }
}
