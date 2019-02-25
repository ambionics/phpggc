<?php

namespace PHPGGC\GadgetChain;

abstract class FileDelete extends \PHPGGC\GadgetChain
{
    public static $type = self::TYPE_FD;
    public $parameters = [
        'remote_file'
    ];
}