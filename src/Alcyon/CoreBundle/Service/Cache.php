<?php

namespace Alcyon\CoreBundle\Service;

use Doctrine\ORM\Mapping\ClassMetaData;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;

class Cache implements CacheItemPoolInterface
{
    protected $cache;

	public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }
    
    public function getItem($key)
    {
        return $this->cache->getItem($key);
    }
    
    public function getItems(array $keys = array())
    {
        return $this->cache->getItems($keys);
    }
    
    public function hasItem($key)
    {
        return $this->cache->hasItem($key);
    }
    
    public function clear()
    {
        return $this->cache->clear();
    }
    
    public function deleteItem($key)
    {
        return $this->cache->deleteItem($key);
    }
    
    public function deleteItems(array $keys)
    {
        return $this->cache->deleteItems($keys);
    }

    public function save(CacheItemInterface $item)
    {
        return $this->cache->save($item);
    }
    
    public function saveDeferred(CacheItemInterface $item)
    {
        return $this->cache->saveDeferred($item);
    }
    
    public function commit()
    {
        return $this->cache->commit();
    }
}