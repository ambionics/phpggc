<?php

class phpthumb
{
    public $tempFilesToDelete = [];

    public function __construct($tempFileToDelete) {
        $this->tempFilesToDelete[] = $tempFileToDelete;
    }

}
