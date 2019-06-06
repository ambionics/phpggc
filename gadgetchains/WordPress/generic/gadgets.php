<?php

/*
	Some notes about how WordPress processes stuff, hopeful saving you some sanity when trying Gadgets.

	In the Front-end, when WordPress is loaded, all $_GET and $_POST
	are passed through add_magic_quotes() [1] which will then call addslashes() [2]. So if the payload is retrieved from
	$_GET/$_POST/$_REQUEST/get_query_var while WordPress is loaded, it will be escaped, leading to an Offset error when unserialized.
	This should be a rare case, as it would mean that the code of the plugin/theme would not even work with legitimate and harmless serialized data. Workarounds seen done by plugin/theme creators to avoid that: base64_decode()/stripslashes()/wp_unslash() the query var/s.

	[1] https://github.com/WordPress/WordPress/blob/52354f3f0b7f2b6e53d6ca3578942d5940f84048/wp-includes/load.php#L917
	[2] https://github.com/WordPress/WordPress/blob/643ec358a40faba739266f11c34990c142f02d98/wp-includes/functions.php#L1057
*/

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