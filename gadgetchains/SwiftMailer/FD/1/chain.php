<?php

namespace GadgetChain\SwiftMailer;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '-5.4.12+, -6.2.1+';
    public static $vector = '__destruct';
    public static $author = 'dsp25no';

    public function generate(array $parameters)
    {
        return new \Swift_ByteStream_TemporaryFileByteStream($parameters['remote_file']);
    }
}
