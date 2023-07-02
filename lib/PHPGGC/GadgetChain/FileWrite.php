<?php

namespace PHPGGC\GadgetChain;

abstract class FileWrite extends \PHPGGC\GadgetChain
{
    public static $type = 'FW';
    public static $type_description = 'File write';

    public static $parameters = [
        'remote_path',
        'local_path'
    ];

    public function process_parameters(array $parameters)
    {
        $local_path = $parameters['local_path'];

        if(!file_exists($local_path))
            throw new \PHPGGC\Exception('Unable to read local file: ' . $parameters['local_path']);

        $parameters['data'] = file_get_contents($local_path);
        return $parameters;
    }

    public function test_setup()
    {
        return [
            'local_path' => \PHPGGC\Util::rand_file('test file write'),
            'remote_path' => \PHPGGC\Util::rand_path('', '.test')
        ];
    }

    public function test_confirm($arguments, $output)
    {
        if(!file_exists($arguments['remote_path']))
            return false;
        
        $expected = file_get_contents($arguments['local_path']);
        $obtained = file_get_contents($arguments['remote_path']);
        
        return strpos($obtained, $expected) !== false;
    }

    public function test_cleanup($arguments)
    {
        if(file_exists($arguments['remote_path']))
            unlink($arguments['remote_path']);
        if(file_exists($arguments['local_path']))
            unlink($arguments['local_path']);
    }
}