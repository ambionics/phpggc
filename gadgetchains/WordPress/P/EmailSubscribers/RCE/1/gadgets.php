<?php

require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');

// EmailSubsribers - https://plugins.svn.wordpress.org/email-subscribers/trunk/lite/includes/logs/log-handlers/class-ig-log-handler-file.php
class IG_Log_Handler_File {
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
