<?php

namespace PHPGGC\GadgetChain;

abstract class FileWrite extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_FW;
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
}