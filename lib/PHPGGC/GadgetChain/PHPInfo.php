<?php

namespace PHPGGC\GadgetChain;

abstract class PHPInfo extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_INFO;

    public function test_setup()
    {
    }

    public function test_confirm($arguments, $output)
    {
        $expected = '<title>phpinfo()</title>';
        return strpos($output, $expected) !== false;
    }
}