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

    class BufferHandler
    {
        protected $handler;
        protected $bufferSize = -1;
        protected $buffer;
        # ($record['level'] < $this->level) == false
        protected $level = null;
        protected $initialized = true;
        # ($this->bufferLimit > 0 && $this->bufferSize === $this->bufferLimit) == false
        protected $bufferLimit = -1;
        protected $processors;

        function __construct($function)
        {
            $this->processors = ['current', $function];
        }
    }

}
