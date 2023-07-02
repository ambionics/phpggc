<?php

namespace PHPGGC\GadgetChain\RCE;

/**
 * Class FunctionCall
 * Executes a PHP function with one argument.
 * @package PHPGGC\GadgetChain\RCE
 */
abstract class FunctionCall extends \PHPGGC\GadgetChain\RCE
{
    public static $type_description = 'RCE: Command';

    public static $parameters = [
        'function',
        'parameter'
    ];

    public function test_setup()
    {
        $command = $this->_test_build_command();
        return [
            'function' => 'system',
            'parameter' =>
                $command
        ];
    }

}