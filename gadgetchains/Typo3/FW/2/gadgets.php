<?php

namespace TYPO3\CMS\Extensionmanager\Controller
{
    class UploadExtensionFileController
    {
        public $extensionBackupPath;

        public function __construct($path, $data) {
            $this->extensionBackupPath = new \TYPO3\CMS\Backend\Template\Components\Buttons\InputButton($path, $data);
        }
    }
}

namespace TYPO3\CMS\Backend\Template\Components\Buttons
{
    class InputButton
    {
        protected $name='';
        protected $classes='';
        protected $value='';
        protected $form='';
        protected $title='';
        protected $icon;

        public function __construct($path, $data) {
            $this->icon = new \TYPO3\CMS\Backend\View\BackendTemplateView($path, $data);
        }
    }
}

namespace TYPO3\CMS\Backend\View
{
    class BackendTemplateView 
    {
        protected $templateView;
        protected $moduleTemplate;

        public function __construct($path, $data) {
            $this->templateView = new \TYPO3\CMS\Extbase\Mvc\View\EmptyView();
            $this->moduleTemplate = new \TYPO3\CMS\Install\FolderStructure\FileNode($path, $data);
        }
    }
}

namespace TYPO3\CMS\Extbase\Mvc\View
{
    class EmptyView
    {
        public function __construct() {
        }
    }
}

namespace TYPO3\CMS\Install\FolderStructure
{
    class FileNode
    {
        protected $parent;
        protected $targetContent;
        protected $name;

        public function __construct($path, $data) {
            $info = pathinfo($path);
            $this->name = $info['basename'];
            $this->parent = new \TYPO3\CMS\Install\FolderStruct\RootNode($info['dirname']);
            $this->targetContent = $data;
        }
    }
}

namespace TYPO3\CMS\Install\FolderStruct
{
    class RootNode
    {
        protected $name;
        
        public function __construct($path) {
            $this->name = $path;
        }
    }
}