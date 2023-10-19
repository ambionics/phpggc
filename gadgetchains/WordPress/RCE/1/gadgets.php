<?php

namespace WpOrg\Requests
{
    class Session 
    {
        public $url;
        public $headers;
        public $options;

        public function __construct($url, $headers, $options) 
        {
            $this->url = $url;
            $this->headers = $headers;
            $this->options = $options;
        }
    }
    
    class Hooks 
    {
        public $hooks;

        public function __construct($hooks) 
        {
            $this->hooks = $hooks;
        }
    }    
}

namespace 
{
    final class WP_Block_Type_Registry 
    {
        public $registered_block_types;

        public function __construct($registered_block_types) 
        {
            $this->registered_block_types = $registered_block_types;
        }
    }
    
    class WP_Block_List 
    {
        public $blocks;
        public $registry;
    
        public function __construct($blocks, $registry) 
        {
            $this->blocks = $blocks;
            $this->registry = $registry;
        }
    }
    
    final class WP_Theme 
    {
        public $headers;
        public $parent;

        public function __construct($headers = null, $parent = null) 
        {
            $this->headers = $headers;
            $this->parent = $parent;
        }
    }
}