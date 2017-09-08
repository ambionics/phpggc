<?php

class Zend_Log
{
    protected $_writers;

    function __construct($x)
    {
        $this->_writers = $x;
    }
}

class Zend_Log_Writer_Mail
{
    protected $_eventsToMail;
    protected $_layoutEventsToMail;
    protected $_mail;
    protected $_layout;
    protected $_subjectPrependText;

    public function __construct(
        $eventsToMail,
        $layoutEventsToMail,
        $mail,
        $layout
    ) {
        $this->_eventsToMail = $eventsToMail;
        $this->_layoutEventsToMail = $layoutEventsToMail;
        $this->_mail = $mail;
        $this->_layout = $layout;
        $this->_subjectPrependText = null;
    }
}

class Zend_Mail
{}

class Zend_Layout
{
    protected $_inflector;
    protected $_inflectorEnabled;
    protected $_layout;

    public function __construct(
        $inflector,
        $inflectorEnabled,
        $layout
    ) {
        $this->_inflector = $inflector;
        $this->_inflectorEnabled = $inflectorEnabled;
        $this->_layout = $layout;
    }
}

class Zend_Filter_PregReplace
{
    protected $_matchPattern;
    protected $_replacement;

    public function __construct(
        $matchPattern,
        $replacement
    ) {
        $this->_matchPattern = $matchPattern;
        $this->_replacement = $replacement;
    }
}
