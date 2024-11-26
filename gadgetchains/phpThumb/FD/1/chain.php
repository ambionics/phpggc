<?php

namespace GadgetChain\phpThumb;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '<= v1.7.22';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'Fixed by https://github.com/JamesHeinrich/phpThumb/pull/226';

    public function generate(array $parameters)
    {
        return new \phpthumb($parameters['remote_path']);
    }
}
