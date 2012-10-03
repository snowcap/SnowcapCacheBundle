<?php

namespace Snowcap\CacheBundle\Tests\Manager;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Snowcap\CacheBundle\DependencyInjection\SnowcapCacheExtension;

class CacheManagerTest extends \PHPUnit_Framework_TestCase
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

    public function testManagerInstantiation()
    {
        $defaultCache = $this->container->get('snowcap_cache.manager')->getCache('default');

        $this->assertInstanceOf('Snowcap\CacheBundle\Cache\MemcachedCache', $defaultCache);
    }
}