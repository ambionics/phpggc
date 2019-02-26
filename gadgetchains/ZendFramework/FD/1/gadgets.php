<?php

class Zend_Http_Response_Stream
{
    protected $_cleanup;
    protected $stream_name;

    public function __construct(
        $cleanup,
        $stream_name
    ) {
        $this->_cleanup = $cleanup;
        $this->stream_name = $stream_name;
    }

}