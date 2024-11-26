<?php

namespace Magento\Framework\Cache\Backend {
    class RemoteSynchronizedCache {
        private $remote;
        private $lockList = [];

        function __construct($remote, $lockList) {
            $this->remote = $remote;
            $this->lockList[] = $lockList;
        }
    }
}

namespace Magento\Framework\Interception {
    class PluginListGenerator {
        private $directoryList;

        function __construct($directoryList) {
            $this->directoryList = $directoryList;
        }
    }
}

namespace Magento\Framework\App\Filesystem {
    class DirectoryList {
        private $directories;

        function __construct($file, $id) {
            $this->directories[$id]['path'] = $file;
        }
    }
}