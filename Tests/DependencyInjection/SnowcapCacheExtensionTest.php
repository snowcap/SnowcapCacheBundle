<?php

namespace Snowcap\CacheBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Snowcap\CacheBundle\DependencyInjection\SnowcapCacheExtension;

class SnowcapCacheExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigLoad()
    {
        $extension = new SnowcapCacheExtension();

        $config = array('namespace' => 'SnowcapCacheBundle');
        $extension->load(array($config), $container = new ContainerBuilder());

        $this->assertEquals(array(), $container->getParameter('snowcap_cache.caches'));
    }

    public function testConfigLoadWithOneCache()
    {
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
        $extension->load(array($config), $container = new ContainerBuilder());

        $this->assertEquals($config['caches'], $container->getParameter('snowcap_cache.caches'));
    }
}