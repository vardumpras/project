<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\Cache;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class CacheTest extends TestCase
{
    public function testGetterSetter()
    {
        $key = 'item';
        $cachePool = $this->createMock(CacheItemPoolInterface::class);
        $cache = new Cache($cachePool);

        $cachePool->expects($this->once())
            ->method('hasItem')
            ->with($this->equalTo($key))
            ->will($this->returnValue(true));
        $this->assertTrue($cache->hasItem($key));

        $cachePool->expects($this->once())
            ->method('getItem')
            ->with($this->equalTo($key))
            ->will($this->returnValue(true));
        $this->assertTrue($cache->getItem($key));

        $cachePool->expects($this->once())
            ->method('getItems')
            ->with($this->equalTo(array($key)))
            ->will($this->returnValue(true));
        $this->assertTrue($cache->getItems(array($key)));


        $cachePool->expects($this->once())
            ->method('deleteItem')
            ->with($this->equalTo($key))
            ->will($this->returnValue($cachePool));
        $this->assertSame($cachePool, $cache->deleteItem($key));


        $cachePool->expects($this->once())
            ->method('deleteItems')
            ->with($this->equalTo(array($key)))
            ->will($this->returnValue($cachePool));
        $this->assertSame($cachePool, $cache->deleteItems(array($key)));

        $item = $this->createMock(CacheItemInterface::class);
        $cachePool->expects($this->once())
            ->method('save')
            ->with($this->equalTo($item))
            ->will($this->returnValue($cachePool));
        $this->assertSame($cachePool, $cache->save($item));

        $cachePool->expects($this->once())
            ->method('saveDeferred')
            ->with($this->equalTo($item))
            ->will($this->returnValue($cachePool));
        $this->assertSame($cachePool, $cache->saveDeferred($item));

        $cachePool->expects($this->once())
            ->method('commit')
            ->will($this->returnValue($cachePool));
        $this->assertSame($cachePool, $cache->commit());

        $cachePool->expects($this->once())
            ->method('clear')
            ->will($this->returnValue($cachePool));
        $this->assertSame($cachePool, $cache->clear());
    }
}