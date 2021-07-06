<?php

namespace GadgetChain\Laminas;

use Laminas\Cache\Psr\CacheItemPool\CacheItem;
use Laminas\Cache\Psr\CacheItemPool\CacheItemPoolDecorator;
use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Cache\Storage\Adapter\FilesystemOptions;


class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '2.8.0 <= 3.0.x-dev';
    public static $vector = '__destruct';
    public static $author = 'swapgs';
    public static $information = '
        This chain requires both laminas/laminas-cache (tested up to 3.0.x-dev) and
        laminas/laminas-cache-storage-adapter-filesystem (a default dependency) to work.
        Asking for a remote filename without extension will create a file with a trailing dot 
        (e.g. asking for `foo` will create `foo.`)
    ';

    public function process_parameters($parameters)
    {
        $parameters = parent::process_parameters($parameters);
        $infos = pathinfo($parameters['remote_path']);
        $parameters['extension'] = isset($infos['extension']) ? $infos['extension'] : '';
        $parameters['filename'] = isset($infos['filename']) ? $infos['filename'] : '';
        $parameters['dirname'] = dirname($parameters['remote_path']);

        return $parameters;
    }

    public function generate(array $parameters)
    {
        return new CacheItemPoolDecorator(
            new Filesystem(
                new FilesystemOptions($parameters['dirname'], $parameters['extension'])
            ),
            [new CacheItem($parameters['filename'], $parameters['data'])]
        );
    }
}