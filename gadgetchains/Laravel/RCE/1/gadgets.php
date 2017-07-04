<?php

namespace Illuminate\Broadcasting
{
	class PendingBroadcast
	{
		protected $events;
		protected $event;

		function __construct($events, $cmd)
		{
			$this->events = $events;
			$this->event = $cmd;
		}
	}
}


namespace Faker
{
	class Generator
	{
		protected $formatters = [
			'dispatch' => 'assert'
		];
	}
}