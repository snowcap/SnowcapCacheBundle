Introduction
============

This bundle is used to provide access to cache drivers.

This is a work in progress with only one driver : Memcached

Installation
------------

1. Add this bundle to your ``vendor/`` dir:

    Add the following lines in your ``deps`` file::

        [SnowcapCacheBundle]
            git=git://github.com/snowcap/SnowcapCacheBundle.git
            target=/bundles/Snowcap/CacheBundle

    Run the vendors script:

        ./bin/vendors install

2. Add the Snowcap namespace to your autoloader:

        // app/autoload.php
        $loader->registerNamespaces(array(
            'Snowcap' => __DIR__.'/../vendor/bundles',
            // your other namespaces
        ));

3. Add this bundle to your application's kernel:

        // app/ApplicationKernel.php
        public function registerBundles()
        {
            return array(
                // ...
                new Snowcap\CacheBundle\SnowcapCacheBundle(),
                // ...
            );
        }

4. Add the configuration in your config.yml

        snowcap_cache:
            namespace: yournamspace
            caches:
                tweets:
                    type: memcached
                    options:
                        server: localhost
                        port: 11211
                        ttl: 86400
                flickr:
                    type: memcached
                    options:
                        server: localhost
                        port: 11211
                        ttl: 45632

Running the tests
-----------------

Before running the tests, you will need to install the bundle dependencies. Do it using composer :

    curl -s http://getcomposer.org/installer | php
    php composer.phar --dev install

Then you can simply launch phpunit

    phpunit