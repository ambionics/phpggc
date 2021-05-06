<?php

namespace Monolog\Handler 
{
    // killchain :  
    // <abstract>__destruct() => <FingersCrossedHandler>close() => <FingersCrossedHandler>flushBuffer() => <GroupHandler>handleBatch($records)
    
    class FingersCrossedHandler {
      protected $passthruLevel;
      protected $buffer = array();
      protected $handler;
    
     public function __construct($param, $handler)
     {
         $this->passthruLevel = 0;
         $this->buffer = ['test' => [$param, 'level' => null]];
         $this->handler = $handler;
     }
    
    }
    
    class GroupHandler {
      protected $processors = array();
      public function __construct($function)
      {
         $this->processors = ['current', $function];
      }
    
    }
}
