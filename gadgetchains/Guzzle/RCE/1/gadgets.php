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

	    /*
	    public function __destruct()
	    {
	        if (isset($this->_fn_close)) {
	            call_user_func($this->_fn_close);
	        }
	    }

	    public function close()
	    {
	        return call_user_func($this->_fn_close);
	    }
	    */
	}
}

namespace GuzzleHttp
{
	class HandlerStack
	{
	    private $handler;
	    private $stack;
	    private $cached = false;

	    function __construct($function, $parameter)
	    {
	    	$this->stack = [[$function]];
	    	$this->handler = $parameter;
	    }

	    /*
	    public function resolve()
	    {
	        if (!$this->cached) {
	            if (!($prev = $this->handler)) {
	                throw new \LogicException('No handler has been specified');
	            }

	            foreach (array_reverse($this->stack) as $fn) {
	                $prev = $fn[0]($prev);
	            }

	            $this->cached = $prev;
	        }

	        return $this->cached;
	    }
	    */
	}
}