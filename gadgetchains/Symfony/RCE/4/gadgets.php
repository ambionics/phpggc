<?php

namespace Symfony\Component\Cache { 

    final class CacheItem 
    { 
        protected $poolHash ; 
        protected $innerItem; 
        public function __construct($poolHash, $parameter) 
        { 
            $this-> poolHash = $poolHash; 
            $this-> innerItem = $parameter; 
        } 
    } 
} 

namespace Symfony\Component\Cache\Adapter { 

    class ProxyAdapter 
    { 
        private $poolHash ; 
        private $setInnerItem; 
        public function __construct($poolHash, $function) 
        { 
            $this-> poolHash = $poolHash; 
            $this-> setInnerItem = $function; 
        } 
    } 

    class TagAwareAdapter 
    { 
        private $deferred = []; 
        private $pool; 
        public function __construct($deferred, $pool) 
        { 
            $this-> deferred = $deferred; 
            $this-> pool = $pool; 
        } 
    } 
} 

?>
