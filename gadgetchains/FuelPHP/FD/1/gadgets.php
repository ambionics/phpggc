<?php

namespace Fuel\Core
{
    class Image_Imagemagick
    {
        public $image_temp;

        public function __construct($file)
        {
            $this->image_temp = $file;
        }
    }
}

