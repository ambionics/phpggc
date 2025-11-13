<?php

namespace Drupal\Core\Database\Transaction {

    interface TransactionManagerInterface {
        public function beginClientTransaction();
        public function rollbackClientTransaction();
        public function commitClientTransaction();
    }

    enum StackItemType: string {
        case Root = 'root';
        case Nested = 'nested';
    }

    enum ClientConnectionTransactionState: string {
        case Committed = 'committed';
        case Rollbacked = 'rollbacked';
    }

    class StackItem {
        protected string $name;
        protected StackItemType $type;

        public function __construct(string $name, StackItemType $type) {
            $this->name = $name;
            $this->type = $type;
        }
    }

    class TransactionManagerBase {
        protected string $rootId;
        protected array $stack;
        protected array $voidedItems;
        protected array $postTransactionCallbacks;
        protected ClientConnectionTransactionState $connectionTransactionState;

        public function __construct(array $voidedItems, array $callbacks, ClientConnectionTransactionState $state, string $rootId = 'x') {
            $this->rootId = $rootId;
            $this->stack = [];
            $this->voidedItems = $voidedItems;
            $this->postTransactionCallbacks = $callbacks;
            $this->connectionTransactionState = $state;
        }
    }
}

namespace Drupal\mysql\Driver\Database\mysql {

    use Drupal\Component\DependencyInjection\Container;
    use Drupal\Core\Database\Transaction\TransactionManagerBase;
    use Drupal\Core\Database\Transaction\TransactionManagerInterface;

    class TransactionManager extends TransactionManagerBase implements TransactionManagerInterface {
        protected ?Container $container = null;

        public function beginClientTransaction() {}
        public function rollbackClientTransaction() {}
        public function commitClientTransaction() {}
    }

    class Connection {
        protected TransactionManager $transactionManager;

        public function __construct(TransactionManager $manager) {
            $this->transactionManager = $manager;
        }
    }
}

namespace Drupal\Component\DependencyInjection {

    class Container {
        protected array $parameters = [];
        protected array $aliases = [];
        protected array $serviceDefinitions = [];
        protected array $services = [];
        protected array $privateServices = [];
        protected array $loading = [];
        protected bool $frozen = false;

        public function __construct(array $definitions) {
            $this->serviceDefinitions = $definitions;
        }
    }
}

namespace Drupal\Core\Database {

    use Drupal\mysql\Driver\Database\mysql\Connection;

    class Transaction {
        protected Connection $connection;
        protected string $name;
        protected string $id;

        public function __construct(Connection $connection, string $name, string $id) {
            $this->connection = $connection;
            $this->name = $name;
            $this->id = $id;
        }
    }
}