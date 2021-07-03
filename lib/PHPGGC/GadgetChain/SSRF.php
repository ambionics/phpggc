<?php
namespace PHPGGC\GadgetChain;

abstract class SSRF extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_SSRF;
    public static $parameters = [
        'uri'
    ];

    public function test_setup()
    {
        throw new \PHPGGC\Exception("SSRF payloads cannot be tested.");
    }

    public function test_confirm($arguments, $output)
    {
        return false;
    }
}
?>
