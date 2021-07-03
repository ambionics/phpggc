<?php

namespace PhpCsFixer
{
//https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/v2.17.3/src/FileRemoval.php
    class FileRemoval
    {

        function __construct($remote_path)
        {
            $this->files = [$remote_path => $remote_path];

        }

    }
}

/* 
    public function __destruct()
    {
        $this->clean();
    }




    public function clean()
    {
        foreach ($this->files as $file => $value) {
            $this->unlink($file);
        }
        $this->files = [];
    }

    private function unlink($path)
    {
        @unlink($path);
    }
}
*/


?>
