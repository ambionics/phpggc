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