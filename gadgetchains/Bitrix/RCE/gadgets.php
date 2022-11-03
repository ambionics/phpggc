<?php

namespace Bitrix\Main {
	class Result
	{
		protected $errors;
		
		public function __construct(object $Dictionary)
		{
			$this->errors = $Dictionary;
		}
	}
	
	class Error {
		protected $message;
		
		public function __construct(object $ItemAttributes)
		{
			$this->message = $ItemAttributes;
		}
	}
}

namespace Bitrix\Main\ORM\Data {
	class Result extends \Bitrix\Main\Result
	{
		protected $isSuccess = false;
		protected $wereErrorsChecked = false;
		
		public function __construct(object $Dictionary)
		{
			parent::__construct($Dictionary);
		}
	}
}

namespace Bitrix\Main\Type {
	class Dictionary
	{
		protected $values;
		
		public function __construct(object $Error)
		{
			$this->values = [$Error];
		}
	}
}

namespace Bitrix\Main\UI\Viewer {
	class ItemAttributes
	{
		protected $attributes;

		public function __construct(object $ResultIterator)
		{
			$this->attributes = $ResultIterator;
		}
	}
}

namespace Bitrix\Main\DB {
	class ResultIterator
	{
		private $counter = 0;
		private $currentData = 0;
		private $result;

		public function __construct(object $ArrayResult)
		{
			$this->result = $ArrayResult;
		}
	}
	
	class ArrayResult
	{
		protected $resource;
		protected $converters;
		
		public function __construct(string $function, string $parameter)
		{
			$this->converters = [$function, 'WriteFinalMessage'];
			$this->resource = [[$parameter], [['rce']]];
		}
	}
}
