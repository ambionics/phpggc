<?php

namespace PHPGGC\GadgetChain;

abstract class RCE extends \PHPGGC\GadgetChain
{

    public static $type = 'RCE';
    public static $type_description = 'RCE';

    # TBD by subclasses
    public static $parameters = [];

    /**
     * The result of the command is not necessarily visible. We write the output
     * to a file instead to be able to tell if the payload worked, even if
     * there's no output.
     */
    protected function _test_build_command()
    {
        $this->__test_rand_token = sha1(rand());
        $this->__test_rand_path = \PHPGGC\Util::rand_path();
        return 
            'echo ' . $this->__test_rand_token .
            ' > ' . $this->__test_rand_path
        ;
    }

    public function test_confirm($arguments, $output)
    {
        if(!file_exists($this->__test_rand_path))
            return false;
        $result = file_get_contents($this->__test_rand_path);
        return strpos($result, $this->__test_rand_token) !== false;
    }

    public function test_cleanup($arguments)
    {
        if(file_exists($this->__test_rand_path))
            unlink($this->__test_rand_path);
    }
}