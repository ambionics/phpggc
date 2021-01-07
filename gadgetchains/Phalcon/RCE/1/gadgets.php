<?php

namespace Phalcon\Di {
  class Service {
  	protected $_shared;
  	protected $_definition;

  	public function __construct() {
  		$this->_shared = false;
  		$this->_definition = array(
  			'className' => '\Phalcon\Mvc\View\Engine\Php',
  			'arguments' => array(array('type' => 'parameter', 'value' => 'test')),
  			'calls' => array(
  				array(
  					'method' => 'render',
  					'arguments' => array(
  						array(
  							'type' => 'parameter',
  							'value' => 'php://input'
  						), array(
  							'type' => 'parameter',
  							'value' => array()
  							)
  						)
  					)
  				)
  			);
  	}
  }
}

namespace Phalcon {
  class Di {
  	protected $_services;

  	public function __construct() {
  		$this->_services = array('session' => new \Phalcon\Di\Service());
  	}
  }
}

namespace Phalcon\Http {
  class Cookie {
  	protected $_dependencyInjector;
  	protected $_name = "test";
  	protected $_expire = 0;
  	protected $_httpOnly = 1;
  	protected $_readed = true;
  	protected $_restored = false;

  	public function __construct() {
  		$this->_dependencyInjector = new \Phalcon\Di();
  	}
  }
}

namespace Phalcon\Logger\Adapter {
  class File {
  	protected $_transaction;
  	protected $_queue;
  	protected $_formatter;
  	protected $_logLevel;
  	protected $_fileHandler;
  	protected $_path;
  	protected $_options;

  	function __construct() {
  		$this->_path = new \Phalcon\Http\Cookie("test");
  	}
  }
}

