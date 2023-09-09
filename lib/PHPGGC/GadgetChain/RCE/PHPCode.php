<?php

namespace PHPGGC\GadgetChain\RCE;

/**
 * Class PHPCode
 * Executes PHP code.
 * @package PHPGGC\GadgetChain\RCE
 */
abstract class PHPCode extends \PHPGGC\GadgetChain\RCE
{
    public static $type_description = 'RCE: PHP Code';

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