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

/*
* Issue was introduced in 4.6 via "HTTP API: Replace internals with Requests library"
* See https://github.com/WordPress/WordPress/blob/6fd8080e7ee7599b36d4528f72a8ced612130b8c/wp-includes/Requests/Utility/FilteredIterator.php
* 
* On October 29th, 2020, WP 5.5.2 was relased, fixing the issue: https://www.wordfence.com/blog/2020/11/unpacking-the-wordpress-5-5-2-5-5-3-security-release/
*
* More details:
* Versions in 5.x branches have been fixed, at the exception of 5.0.x
*             4.x from 4.6 are still vulnerable.
*
* 5.5.x, fixed in 5.5.2
* 5.4.x, fixed in 5.4.3
* 5.3.x, fixed in 5.3.5
* 5.2.x, fixed in 5.2.8
* 5.1.x, fixed in 5.1.7
* 5.0.x still vulnerable (latest checked 5.0.11)
* 4.9.x still vulnerable (latest checked 4.9.16)
* 4.8.x still vulnerable (latest checked 4.8.15)
* 4.7.x still vulnerable (latest checked 4.7.19)
* 4.6.x still vulnerable (latest checked 4.6.20)
*/
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