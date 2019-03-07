<?php

namespace PHPGGC\GadgetChain;

abstract class FileRead extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_FR;
    public static $parameters = [
        'remote_file'
    ];
}