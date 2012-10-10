<?php

namespace Snowcap\CacheBundle\Cache;

use Snowcap\CacheBundle\Exception\CacheException;

class ApcCache extends AbstractCache
{
    /**
     * @var int
     */
    private $ttl = 3600;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @param string $namespace
     * @param string $identifier
     * @param array  $options
     */
    public function __construct($namespace, $identifier, array $options)
    {
        parent::__construct($namespace, $identifier, $options);
        $this->prefix = $namespace . '.' . $identifier . '.';
        if (isset($options['ttl'])) {
            $this->ttl = $options['ttl'];
        }
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return apc_fetch($this->prefix . $key);
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        if (!apc_store($this->prefix . $key, $value, $this->ttl)) {
            throw new CacheException('Cannot store key/value pair in apc cache');
        }
    }

    /**
     * @param string $key
     */
    public function delete($key)
    {
        apc_delete($this->prefix . $key);
    }

    /**
     * Check if the driver is available and running
     *
     * @return bool
     */
    public function isEnabled()
    {
        return extension_loaded('apc') && ini_get('apc.enabled');
    }

    /**
     * Get information about the cache driver
     *
     * @return mixed
     */
    public function getInfo()
    {
        return @apc_cache_info();
    }


}
