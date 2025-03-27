<?php

namespace PHPGGC\GadgetChain;

abstract class XXE extends \PHPGGC\GadgetChain
{
    public static $type = 'XXE';
    public static $type_description = 'XML External Entity';

    public static $parameters = [
        'local_file'
    ];

    public function test_setup()
    {
        throw new \PHPGGC\Exception("XXE payloads cannot be tested.");
    }

    public function test_confirm($arguments, $output)
    {
        return false;
    }
    
    public function process_parameters(array $parameters)
    {
        if (!file_exists($parameters['local_file'])) {
            throw new \PHPGGC\Exception("File '{$parameters['local_file']}' does not exist");
        }
        
        $parameters['xml_content'] = file_get_contents($parameters['local_file']);
        return $parameters;
    }
} 