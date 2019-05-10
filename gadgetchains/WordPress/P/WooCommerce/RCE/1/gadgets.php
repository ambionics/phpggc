<?php

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

// WordPress - https://github.com/WordPress/WordPress/blob/6fd8080e7ee7599b36d4528f72a8ced612130b8c/wp-includes/Requests/Utility/FilteredIterator.php
class Requests_Utility_FilteredIterator extends ArrayIterator {
	protected $callback;

	public function __construct($data, $callback) {
		parent::__construct($data);
		$this->callback = $callback;
	}

	/*
	public function current() {
		$value = parent::current();
		$value = call_user_func($this->callback, $value);
		return $value;
	}
	*/
}
