<?php

namespace GuzzleHttp\Cookie
{
	class FileCookieJar
	{
		private $filename;
		
		public function __construct($r)
		{
		    $this->filename = $r;
		}
	}
}

namespace Illuminate\Validation\Rules
{	
	class RequiredIf
	{  
		public function __construct($p)
		{
		    $this->condition = [$p, 'get'];
		}
	}
}

namespace PhpOption
{
    final class LazyOption
    {
        private $callback;
        private $arguments;

        function __construct($callback, $arguments)
        {
            $this->callback = $callback;
            $this->arguments = $arguments;
        }
    }
}