<?php

require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');

// WooCommerce - https://plugins.trac.wordpress.org/browser/woocommerce/trunk/includes/log-handlers/class-wc-log-handler-file.php
class WC_Log_Handler_File {
	protected $handles = array();

	// Custom constructor to set the $handles more easily
	public function __construct($handles) {
		$this->handles = $handles;
	}

	/*
	public function __destruct() {
		foreach ( $this->handles as $handle ) {
			if ( is_resource( $handle ) ) {
				fclose( $handle ); // @codingStandardsIgnoreLine.
			}
		}
	}
	*/
}
