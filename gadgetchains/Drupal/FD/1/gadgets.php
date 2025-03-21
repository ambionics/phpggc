<?php

namespace Drupal\Core\Config {
    class StorageComparer {
        protected $targetCacheStorage;
        public function __construct($targetCacheStorage)
        {
            $this->targetCacheStorage = $targetCacheStorage;
        }
    }
}

namespace Drupal\Component\PhpStorage {
    class FileStorage {
        protected $directory;
        public function __construct($directory)
        {
            $this->directory = $directory;
        }
    }
}