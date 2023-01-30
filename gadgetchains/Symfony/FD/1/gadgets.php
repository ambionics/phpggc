<?php
namespace Symfony\Component\Cache\Adapter{
    class PhpFilesAdapter{
        private $tmp;

        function __construct($path){
            $this->tmp = $path;
        }
    }
}
