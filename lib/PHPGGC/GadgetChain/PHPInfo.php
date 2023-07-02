<?php

namespace PHPGGC\GadgetChain;

abstract class PHPInfo extends \PHPGGC\GadgetChain
{
    public static $type = 'INFO';
    public static $type_description = 'phpinfo()';

    public function test_setup()
    {
        return [];
    }

    public function test_confirm($arguments, $output)
    {
        $expected = [
            'phpinfo()',
            'PHP Authors',
            'Module Authors',
            'PHP Variables'
        ];
        foreach($expected as $needle)
            if(strpos($output, $needle) === false)
                return false;

        return true;
    }
}