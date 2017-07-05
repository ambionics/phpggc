<?php
namespace Doctrine\ORM\Mapping\Driver
{
    use Doctrine\Common\Persistence\Mapping\Driver\AnnotationDriver as AbstractAnnotationDriver;

    class AnnotationDriver extends AbstractAnnotationDriver
    {

    }
}

namespace Doctrine\Common\Persistence\Mapping\Driver
{
    class AnnotationDriver
    {
        protected $reader;
        protected $paths = [];
        protected $excludePaths = [];
        protected $fileExtension = '.php';
        protected $classNames;
        protected $entityAnnotationClasses = [];

        function __construct($reader)
        {
            $this->reader = $reader;
        }
    }
}

namespace Doctrine\Common\Annotations
{
    final class CachedReader
    {
        private $delegate;
        private $cache;
        private $debug;
        private $loadedAnnotations;

        function __construct($loadedAnnotations)
        {
            $this->loadedAnnotations = $loadedAnnotations;
        }
    }
}

namespace Doctrine\ORM\Query
{
    class ResultSetMapping
    {
        public $isMixed = false;
        public $isSelect = true;
        public $aliasMap = array();
        public $relationMap = array();
        public $parentAliasMap = array();
        public $fieldMappings = array();
        public $scalarMappings = array();
        public $typeMappings = array();
        public $entityMappings = array();
        public $metaMappings = array();
        public $columnOwnerMap = array();
        public $discriminatorColumns = array();
        public $indexByMap = array();
        public $declaringClasses = array();
        public $isIdentifierColumn = array();
        public $newObjectMappings = array();
        public $metadataParameterMapping = array();
    }

    # $class = $this->em->getClassMetadata($this->declaringClasses[$columnName]);
    # $sql  .= $class->fieldMappings[$this->fieldMappings[$columnName]]['columnName'];
    class ResultSetMappingBuilder extends ResultSetMapping
    {
        private $em;

        function __construct($em)
        {
            $columnName = 'X';
            $this->columnOwnerMap[$columnName] = null;
            $this->fieldMappings[$columnName] = 0;
            $this->declaringClasses[$columnName] = 'stdClass';
            $this->em = $em;
        }
    }
}

namespace Doctrine\ORM
{
    class EntityManager
    {
        private $config;
        private $conn;
        private $metadataFactory;
        private $unitOfWork;
        private $eventManager;
        private $proxyFactory;
        private $repositoryFactory;
        private $expressionBuilder;
        private $closed = false;
        private $filterCollection;
        private $cache;

        function __construct($metadataFactory, $config)
        {
            $this->metadataFactory = $metadataFactory;
            $this->config = $config;
        }
    }

    class Configuration extends \Doctrine\DBAL\Configuration
    {

    }
}

namespace Doctrine\DBAL
{
    class Configuration
    {
        protected $_attributes = array();

        function __construct($_attributes)
        {
            $this->_attributes = $_attributes;
        }
    }
}

namespace Doctrine\Common\Persistence\Mapping
{
    abstract class AbstractClassMetadataFactory
    {
        protected $cacheSalt = '$CLASSMETADATA';
        private $cacheDriver;
        private $loadedMetadata = [];
        protected $initialized = true;
        private $reflectionService = null;

        function __construct($cacheDriver)
        {
            $this->cacheDriver = $cacheDriver;
        }
    }
}

namespace Doctrine\ORM\Mapping
{
    use \Doctrine\Common\Persistence\Mapping\AbstractClassMetadataFactory;
    use \Doctrine\Common\EventManager;

    class ClassMetadataFactory extends AbstractClassMetadataFactory
    {
        private $em;
        private $targetPlatform;
        private $driver;
        private $evm;
        private $embeddablesActiveNesting = array();

        function __construct($cacheDriver, $em, $driver)
        {
            parent::__construct($cacheDriver);
            $this->em = $em;
            $this->driver = $driver;
            $this->evm = new EventManager();
        }
    }
}

namespace Doctrine\Common\Persistence\Mapping\Driver
{
    class DefaultFileLocator
    {
        protected $paths = [''];
        protected $fileExtension;
    }
}

namespace Doctrine\Common\Persistence\Mapping\Driver
{
    abstract class FileDriver
    {
        protected $locator;
        protected $classCache;
        protected $globalBasename;
    }

    class PHPDriver extends FileDriver
    {
        protected $metadata;
    }
}

namespace Doctrine\Common\Cache
{
    abstract class CacheProvider
    {
        private $namespace = '';
        private $namespaceVersion;
    }

    abstract class FileCache extends CacheProvider
    {
        protected $directory;
        private $extension;
        private $umask = ~0777;
        private $directoryStringLength;
        private $extensionStringLength;
        private $isRunningOnWindows;

        function __construct($directory, $extension)
        {
            $this->directory = $directory;
            $this->extension = $extension;
        }
    }

    class FilesystemCache extends FileCache
    {
    }
}


namespace Doctrine\Common
{
    class EventManager
    {
        private $_listeners = [];
    }
}