<?php

namespace PHPGGC;

/**
 * Utility functions.
 */
class Util
{
    /**
     * Creates a file in the temporary directory.
     * 
     * @param string $name Filename
     * @param string $contents Contents of the file 
     * 
     * @return string Full path to the file
     */
    static public function temp_file($name, $contents)
    {
        $path = static::temp_path($name);
        file_put_contents($path, $contents);
        return $path;
    }

    /**
     * Creates a file in the temporary directory.
     * 
     * @param string $contents Contents of the file 
     * @param string $prefix A string to prepend to the filename
     * @param string $suffix A string to append to the filename
     * 
     * @return string Full path to the file
     */
    static public function rand_file($contents, $prefix='', $suffix='')
    {
        $path = static::rand_path($prefix, $suffix);
        file_put_contents($path, $contents);
        return $path;
    }
    
    /**
     * Returns a random temporary file path. 
     * 
     * @param string $prefix A string to prepend to the filename
     * @param string $suffix A string to append to the filename
     * 
     * @return string Full path to the file
     */
    static public function rand_path($prefix='', $suffix='')
    {
        return static::temp_path(
            $prefix . 'phpggc' . sha1(rand()) . $suffix
        );
    }

    /**
     * Returns a temporary file path whose basename is $name
     * 
     * @param string $name Name of the temporary file
     * 
     * @return string Full path to the file
     */
    static public function temp_path($name)
    {
        return sys_get_temp_dir() . DIRECTORY_SEPARATOR . $name;
    }
}