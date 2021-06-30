<?php

namespace Doctrine\Common\Cache\Psr6
{
	class CacheAdapter
    {
		private $deferredItems = [];

		public function __construct($CacheItem, $FilesystemCache)
        {
			$this->deferredItems = ['x' => $CacheItem];
			$this->cache = $FilesystemCache;
		}
	}
	class CacheItem
    {
		private $value;

		public function __construct($phpCode)
        {
			$this->value = $phpCode;
		}
	}
}

namespace Doctrine\Common\Cache
{
	class FileCache
    {
		private $extension;
		protected $directory;
		private $umask = 0002;

		public function __construct($extension, $directory)
        {
			$this->extension = $extension;
			$this->directory = $directory;
		}
	}
	
	class FilesystemCache extends FileCache {}
}
