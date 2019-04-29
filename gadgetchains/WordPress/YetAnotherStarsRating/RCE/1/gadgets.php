<?php

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

// https://plugins.trac.wordpress.org/browser/yet-another-stars-rating/tags/1.8.6/lib/yasr-shortcode-functions.php#L169 
/*
function shortcode_visitor_votes_callback ($atts) {
	[SNIPPED]

	//name of cookie to check
    $yasr_cookiename = 'yasr_visitor_vote_cookie';

    if (isset($_COOKIE[$yasr_cookiename])) {

        $cookie_data = stripslashes($_COOKIE[$yasr_cookiename]);
        $cookie_data = unserialize($cookie_data);

        foreach ($cookie_data as $value) {

     [SNIPPED]
*/