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
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value);

    /**
     * @param string $key
     */
    public function delete($key);
}
