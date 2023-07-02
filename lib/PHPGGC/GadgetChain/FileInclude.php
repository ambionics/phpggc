<?php

namespace PHPGGC\GadgetChain;

abstract class FileInclude extends \PHPGGC\GadgetChain
{
    public static $type = 'FI';
    public static $type_description = 'File include';

    public static $parameters = [
        'remote_path'
    ];

    public function test_setup()
    {
        return [
            'remote_path' => \PHPGGC\Util::rand_file('<?php echo "test" . "file" . "include"; ?>')
        ];
    }

    public function test_confirm($arguments, $output)
    {
        return strpos($output, "testfileinclude") !== false;
    }

    public function test_cleanup($arguments)
    {
        if(file_exists($arguments['remote_path']))
            unlink($arguments['remote_path']);
    }
}