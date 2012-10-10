<?php

namespace Snowcap\CacheBundle\Cache;

use Snowcap\CacheBundle\Exception\CacheException;

class MemcachedCache extends AbstractCache
{
    /**
     * @var \Memcached
     */
    private $driver;

    /**
     * @var int
     */
    private $ttl = 3600;

    /**
     * @param string $namespace
     * @param string $identifier
     * @param array  $options
     */
    public function __construct($namespace, $identifier, array $options)
    {
        parent::__construct($namespace, $identifier, $options);
        $this->driver = new \Memcached();
        $this->driver->setOption(\Memcached::OPT_PREFIX_KEY, $namespace . '.' . $identifier . '.');
        if (!isset($options['server']) || !isset($options['port'])) {
            throw new \InvalidArgumentException(sprintf('Memcached is expecting a "server" and "port" options'));
        }
        if (!$this->driver->addServer($options['server'], $options['port'])) {
            throw new CacheException('The memcached server could not be added');
        }
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
        return $this->driver->get($key);
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        $this->driver->set($key, $value, time() + $this->ttl);
    }

    /**
     * @param string $key
     */
    public function delete($key)
    {
        $this->driver->delete($key);
    }

    /**
     * Check if the driver is available and running
     *
     * @return bool
     */
    public function isEnabled()
    {
        if (!extension_loaded('memcached')) {
            return false;
        }

        return true;
    }

    /**
     * Get information about the cache driver
     *
     * @return mixed
     */
    public function getInfo()
    {
        return $this->driver->getStats();
    }


}
