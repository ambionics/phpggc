<?php

namespace PHPGGC\GadgetChain;

abstract class FileDelete extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_FD;
    public static $parameters = [
        'remote_path'
    ];

    public function test_setup()
    {
        return [
            'remote_path' => \PHPGGC\Util::rand_file('test file delete')
        ];
    }

    public function test_confirm($arguments, $output)
    {
        return !file_exists($arguments['remote_path']);
    }

    public function test_cleanup($arguments)
    {
        if(file_exists($arguments['remote_path']))
            unlink($arguments['remote_path']);
    }
}