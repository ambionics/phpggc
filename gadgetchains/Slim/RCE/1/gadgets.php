<?php

namespace Pimple
{
	class Container
	{
	    private $raw;
	    private $values;
	    private $keys;

	    function __construct($array)
	    {
	    	$this->keys = $this->raw = $this->values = $array;
	    }
	}
}

namespace Slim
{
	class App
	{
		private $container;

	    function __construct($container)
	    {
	    	$this->container = $container;
	    }
	}

	class Container extends \Pimple\Container
	{

	}
}

namespace Slim\Http
{
	use \Slim\App;
	use \Slim\Container;

	abstract class Message
	{
	    protected $headers;
	    protected $body = '';

	    function __construct($code)
	    {
	    	$z = new App(new Container(['has' => 'assert']));
	    	$y = new App($z);
	    	$this->headers = new App(new Container(['all' => [$y, $code]]));
	    }
	}

	class Response extends Message
	{

	}
}