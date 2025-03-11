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

namespace Magento\Framework\App\ObjectManager\ConfigLoader {
    class Compiled {
    }
}