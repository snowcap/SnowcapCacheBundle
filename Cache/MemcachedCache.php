<?php

namespace Snowcap\CacheBundle\Cache;

class MemcachedCache implements CacheInterface
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
        $this->driver = new \Memcached();
        $this->driver->setOption(\Memcached::OPT_PREFIX_KEY, $namespace . '.' . $identifier . '.');
        if (!isset($options['server']) || !isset($options['port'])) {
            throw new \InvalidArgumentException(sprintf('Memcached is expecting a "server" and "port" options'));
        }
        $this->driver->addServer($options['server'], $options['port']);
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
}
