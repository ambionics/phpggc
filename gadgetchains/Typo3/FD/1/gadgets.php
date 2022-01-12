<?php

namespace TYPO3\CMS\Extensionmanager\Controller;

class UploadExtensionFileController
{
    public $extensionBackupPath;

    public function __construct($extensionBackupPath) {
        $this->extensionBackupPath = $extensionBackupPath;
    }

}
