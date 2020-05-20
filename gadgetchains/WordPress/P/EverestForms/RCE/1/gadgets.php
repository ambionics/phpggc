<?php

require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');

// EverestForms - https://plugins.svn.wordpress.org/everest-forms/trunk/includes/log-handlers/class-evf-log-handler-file.php
class EVF_Log_Handler_File {
	protected $handles = array();

	// Custom constructor to set the $handles more easily
	public function __construct($handles) {
		$this->handles = $handles;
	}

	/*
	public function __destruct() {
		foreach ( $this->handles as $handle ) {
			if ( is_resource( $handle ) ) {
				fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
			}
		}
	}
	*/
}
