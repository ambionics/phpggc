<?php
namespace Psr\Http\Message
{
  interface StreamInterface{}
}

namespace GuzzleHttp\Psr7
{
  class FnStream implements \Psr\Http\Message\StreamInterface
  {
    private $methods;

    public function __construct(array $methods)
    {
      $this->methods = $methods;

      foreach ($methods as $name => $fn) {
        $this->{'_fn_' . $name} = $fn;
      }
    }
  }
}

namespace Pydio\Core\Controller
{
  class ShutdownScheduler 
  {
    private $callbacks;
    public function __construct($function, $parameter) {
      $this->callbacks = [[$function, $parameter]]; 
    }
  }
}


