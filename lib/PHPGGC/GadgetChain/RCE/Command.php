<?php

namespace PHPGGC\GadgetChain\RCE;

/**
 * Class Command
 * Executes a command (bash/batch).
 * @package PHPGGC\GadgetChain\RCE
 */
abstract class Command extends \PHPGGC\GadgetChain\RCE
{
    public static $type_description = 'RCE: Command';

    public static $parameters = [
        'command'
    ];
    
    public function test_setup()
    {
        $command = $this->_test_build_command();
        return [
            'command' => $command
        ];
    }

}