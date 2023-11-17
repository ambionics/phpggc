<?php

namespace 
{
    class WP_HTML_Token 
    {
        public $bookmark_name;
        public $on_destroy;
        
        public function __construct($bookmark_name, $on_destroy) 
        {
            $this->bookmark_name = $bookmark_name;
            $this->on_destroy = $on_destroy;
        }
    }
}
