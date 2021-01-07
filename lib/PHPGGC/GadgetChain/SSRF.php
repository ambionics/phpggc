<?php
namespace PHPGGC\GadgetChain;

abstract class SSRF extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_SSRF;
    public static $parameters = [
        'uri'
    ];
}
?>
