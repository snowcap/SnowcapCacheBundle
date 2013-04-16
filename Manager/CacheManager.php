<?php

namespace Snowcap\CacheBundle\Manager;

use Snowcap\CacheBundle\Cache\CacheInterface;

class CacheManager
{
    /**
     * @var string
     */
    private $namespace;
    /**
     * @var array
     */
    private $cacheConfigs;
    /**
     * @var array
     */
    private $caches = array();
    private $cacheTypes = array(
        'memcached' => 'Snowcap\CacheBundle\Cache\MemcachedCache',
        'apc' => 'Snowcap\CacheBundle\Cache\ApcCache',
    );

    /**
     * @param string $namespace
     * @param array $cacheConfigs
     */
    public function __construct($namespace, array $cacheConfigs)
    {
        $this->namespace = $namespace;
        $this->cacheConfigs = $cacheConfigs;
    }

    /**
     * @param string $cacheIdentifier
     * @return CacheInterface
     */
    public function getCache($cacheIdentifier)
    {
        if (!isset($this->caches[$cacheIdentifier])) {
            $this->caches[$cacheIdentifier] = $this->buildCache($cacheIdentifier);
        }

        return $this->caches[$cacheIdentifier];
    }

    /**
     * @param string $cacheIdentifier
     * @return CacheInterface
     * @throws \InvalidArgumentException
     */
    private function buildCache($cacheIdentifier)
    {
        if (!isset($this->cacheConfigs[$cacheIdentifier])) {
            throw new \InvalidArgumentException(sprintf(
                'The cache with identifier "%s" has not been registered',
                $cacheIdentifier
            ));
        }

        $cacheConfig = $this->cacheConfigs[$cacheIdentifier];

        if (!isset($this->cacheTypes[$cacheConfig['type']])) {
            throw new \InvalidArgumentException(sprintf('The cache type "%s" does not exist', $cacheConfig['type']));
        }

        $className = $this->cacheTypes[$cacheConfig['type']];

        return new $className($this->namespace, $cacheIdentifier, $cacheConfig['options']);
    }
}