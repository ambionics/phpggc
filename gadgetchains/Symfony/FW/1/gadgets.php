<?php

namespace Symfony\Component\HttpKernel\Profiler
{
	class Profile
	{
	    private $token;
	    private $collectors = array();
	    private $ip;
	    private $method;
	    private $url;
	    private $time;
	    private $parent;
	    private $children = array();

		function __construct($path, $content)
		{
			$this->token = uniqid();
			$this->ip = new \Symfony\Component\Finder\Expression\Expression(
				$path, $content
			);
		}
	}
}

namespace Symfony\Component\Finder\Expression
{
	class Expression
	{
		private $value;

		function __construct($path, $content)
		{
			$this->value = new \Symfony\Component\Console\Helper\Table(
				$path, $content
			);
		}
	}
}

namespace Symfony\Component\Console\Helper
{
	class Table
	{
	    private $headers = ['a'];
	    private $rows = [];
	    private $columnWidths = [100];
	    private $numberOfColumns;
	    private $output;
	    private $style;
	    private static $styles;

	    function __construct($path, $content)
	    {
	    	$this->output = new \Symfony\Component\Config\ConfigCache($path);
	    	$this->style = new TableStyle($content);
	    }
	}

	class TableStyle
	{
	    private $paddingChar = ' ';
	    private $horizontalBorderChar = '';
	    private $verticalBorderChar;
	    private $crossingChar = '';
	    private $cellHeaderFormat = '<info>%s</info>';
	    private $cellRowFormat = '%s';
	    private $cellRowContentFormat = ' %s ';
	    private $borderFormat = '%s';
	    private $padType = STR_PAD_RIGHT;

	    function __construct($verticalBorderChar)
	    {
	    	$this->verticalBorderChar = $verticalBorderChar;
	    }
	}
}

namespace Symfony\Component\Config
{
	class ConfigCache
	{
	    private $debug;
	    private $file;

	    function __construct($file)
	    {
	    	$this->file = $file;
	    }
	}
}
