<?php

namespace Snowcap\CacheBundle\Tests\Cache;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Snowcap\CacheBundle\DependencyInjection\SnowcapCacheExtension;

class ApcCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    protected function setUp()
    {
        if (!ini_get('apc.enable_cli')) {
            if (!ini_set('apc.enable_cli', 1)) {
                $this->markTestSkipped('apc.enable_cli should be On');
            }
        }

        $this->container = new ContainerBuilder();
        $extension = new SnowcapCacheExtension();

        $config = array(
            'namespace' => 'SnowcapCacheBundle',
            'caches'    => array(
                'default' => array(
                    'type'    => 'apc',
                    'options' => array('ttl' => 3600)
                )
            )
        );

        $extension->load(array($config), $this->container);
    }

    public function testInfo()
    {
        $defaultCache = $this->container->get('snowcap_cache.manager')->getCache('default');

        $info = $defaultCache->getInfo();

        $this->assertNotEmpty($info);

    }

    public function testSet()
    {
        $defaultCache = $this->container->get('snowcap_cache.manager')->getCache('default');

        $defaultCache->set('foo', 'bar');

        $this->assertEquals('bar', $defaultCache->get('foo'));
    }
}