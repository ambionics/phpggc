<?php

namespace
{
    require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');
}

namespace Dompdf\Adapter
{
    // https://github.com/dompdf/dompdf/blob/master/src/Adapter/CPDF.php
    class CPDF
    {
        // Since 0.8.5, this attribute is protected (was private before)
        protected $_image_cache;

        // Custom contrustor to set the payload
        public function __construct($image_cache)
        {
          $this->_image_cache = $image_cache;
        }

        /*
        public function __destruct()
        {
            foreach ($this->_image_cache as $img) {
                // The file might be already deleted by 3rd party tmp cleaner,
                // the file might not have been created at all
                // (if image outputting commands failed)
                // or because the destructor was called twice accidentally.
                if (!file_exists($img)) {
                    continue;
                }

                if ($this->_dompdf->getOptions()->getDebugPng()) {
                    print '[__destruct unlink ' . $img . ']';
                }
                if (!$this->_dompdf->getOptions()->getDebugKeepTemp()) {
                    unlink($img);
                }
            }
        }
        */
    }
}