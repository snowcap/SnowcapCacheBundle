<?php

namespace Snowcap\CacheBundle\Cache;

interface CacheInterface
{
    /**
     * @param string       $namespace Namespace shared between all caches
     * @param string       $identifier Name of the cache
     * @param array        $options Array of options
     */
    public function __construct($namespace, $identifier, array $options);

    /**
     * Get the value stored for a specific key in the cache driver
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Set a key/value in the cache driver
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value);

    /**
     * Delete a key from the cache driver
     *
     * @param string $key
     */
    public function delete($key);

    /**
     * Check if the driver is available
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Get information about the cache driver
     *
     * @return mixed
     */
    public function getInfo();
}
