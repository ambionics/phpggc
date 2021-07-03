<?php

namespace PHPGGC\GadgetChain\RCE;

/**
 * Class PHPCode
 * Executes PHP code.
 * @package PHPGGC\GadgetChain\RCE
 */
abstract class PHPCode extends \PHPGGC\GadgetChain\RCE
{
    public static $type = self::TYPE_RCE_PHPCODE;
    public static $parameters = [
        'code'
    ];
    
    public function test_setup()
    {
        # TODO file_put_contents() might be a better option here, but it'll work
        # for now.
        $command = $this->_test_build_command();
        return [
            'code' => 'system(' . var_export($command, true) . ');'
        ];
    }
}