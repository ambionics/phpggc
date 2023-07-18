<?php

namespace CodeIgniter\Cache\Handlers {
    class RedisHandler {
        protected $redis;

        public function __construct($remote_path) {
            $this->redis = new \CodeIgniter\Session\Handlers\MemcachedHandler(
                new \CodeIgniter\Cache\Handlers\FileHandler($remote_path),
                $remote_path
            );
        }
    }

    class FileHandler {
        protected $prefix;
        protected $path = "";

        public function __construct($remote_path) {
            $this->prefix = dirname($remote_path) . "/";
        }
    }
}

namespace CodeIgniter\Session\Handlers {
    class MemcachedHandler {
        protected $memcached;
        protected $lockKey;

        public function __construct($memcached, $remote_path) {
            $this->memcached = $memcached;
            $this->lockKey = basename($remote_path);
        }
    }
}