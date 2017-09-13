<?php

namespace PHPGGC\GadgetChain;

abstract class FileRead extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_FR;
    public $parameters = [
        'remote_file'
    ];
}