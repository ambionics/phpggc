<?php
namespace PhpCsFixer\Linter
{
    //https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/v2.17.3/src/Linter/ProcessLinter.php
    class ProcessLinter
    {

        function __construct($remote_file)
        {
            $this->temporaryFile = $remote_file;
            $this->fileRemoval = new \PhpCsFixer\FileRemoval();

        }

        /*
        public function __destruct()
        {
        if (null !== $this->temporaryFile) {
            $this->fileRemoval->delete($this->temporaryFile);
        }
        }
        */

    }
}

namespace PhpCsFixer
{

    //https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/v2.17.3/src/FileRemoval.php
    class FileRemoval

    {

        public function delete($path)
        {
            if (isset($this->files[$path]))
            {
                unset($this->files[$path]);
            }
            $this->unlink($path);
        }
        private function unlink($path)
        {
            @unlink($path);
        }

    }
}

/*
        public function delete($path)
    {
        if (isset($this->files[$path])) {
            unset($this->files[$path]);
        }
        $this->unlink($path);
    }

*/

?>
