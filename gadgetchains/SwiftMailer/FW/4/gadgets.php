<?php

class Swift_Events_SimpleEventDispatcher
{
}

abstract class Swift_Transport_AbstractSmtpTransport
{
    protected $_buffer;
    protected $_started = true;
    protected $_eventDispatcher;

}

class Swift_Transport_SendmailTransport extends Swift_Transport_AbstractSmtpTransport
{
    function __construct($_buffer, $_eventDispatcher)
    {
        $this->_buffer = $_buffer;
        $this->_eventDispatcher = $_eventDispatcher;
    }
}

abstract class Swift_ByteStream_AbstractFilterableInputStream
{
    private $_filters = array();
    private $_writeBuffer;

    function __construct($_writeBuffer)
    {
        $this->_writeBuffer = $_writeBuffer;
    }
}

class Swift_ByteStream_FileByteStream extends Swift_ByteStream_AbstractFilterableInputStream
{
    private $_path;
    private $_mode = 'w+b';

    function __construct($_path, $_writeBuffer)
    {
        parent::__construct($_writeBuffer);
        $this->_path = $_path;
    }
}