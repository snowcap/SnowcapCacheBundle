<?php

namespace Snowcap\CacheBundle\Tests\Cache;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Snowcap\CacheBundle\DependencyInjection\SnowcapCacheExtension;

class MemcachedCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $extension = new SnowcapCacheExtension();

        $config = array(
            'namespace' => 'SnowcapCacheBundle',
            'caches'    => array(
                'default' => array(
                    'type'    => 'memcached',
                    'options' => array('server' => 'localhost', 'port' => 11211)
                )
            )
        );

        $extension->load(array($config), $this->container);
    }


    public function testSet()
    {
        $defaultCache = $this->container->get('snowcap_cache.manager')->getCache('default');

        $defaultCache->set('foo', 'bar');

        $this->assertEquals('bar', $defaultCache->get('foo'));
    }
}