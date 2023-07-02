<?php

namespace PHPGGC\GadgetChain;

abstract class FileRead extends \PHPGGC\GadgetChain
{
    public static $type = 'FR';
    public static $type_description = 'File read';

    public static $parameters = [
        'remote_path'
    ];

    public function test_setup()
    {
        return [
            'remote_path' => \PHPGGC\Util::rand_file('test file read')
        ];
    }

    public function test_confirm($arguments, $output)
    {
        $expected = file_get_contents($arguments['remote_path']);
        return strpos($output, $expected) !== false;
    }

    public function test_cleanup($arguments)
    {
        if(file_exists($arguments['remote_path']))
            unlink($arguments['remote_path']);
    }
}