<?php
namespace Laminas\Http\Response {
    class Stream {
        function __construct($remote_file) {
            $this->cleanup = '1';
            $this->streamName = $remote_file;
        }
    }
}
