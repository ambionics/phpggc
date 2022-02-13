<?php

namespace Magento\Framework\Filesystem\Driver {
    class File {}
}

namespace Magento\Framework\Filesystem\Directory {
    class Write {
        public function __construct() {
            $this->driver = new \Magento\Framework\Filesystem\Driver\File();
        }
    }
}

namespace Magento\RemoteStorage\Plugin {
    class Image {
        public function __construct($file) {
            $this->tmpDirectoryWrite = new \Magento\Framework\Filesystem\Directory\Write();
            $this->tmpFiles = [$file];
        }
    }
}
