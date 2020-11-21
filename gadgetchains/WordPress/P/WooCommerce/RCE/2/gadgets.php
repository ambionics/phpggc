<?php

require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');

// WooCommerce - https://plugins.trac.wordpress.org/browser/woocommerce/trunk/includes/log-handlers/class-wc-log-handler-file.php
class WC_Logger
{
    private $_handles;

    // Custom constructor to set the $handles more easily
    public function __construct($handles)
    {
        $this->_handles = $handles;
    }
}
