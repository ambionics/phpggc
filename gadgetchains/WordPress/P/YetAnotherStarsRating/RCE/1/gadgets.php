<?php

require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');

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