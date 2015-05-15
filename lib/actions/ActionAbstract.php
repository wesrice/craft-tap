<?php
namespace Tap\Actions;

use Tap\Tap;
use League\Fractal\Manager;
use Craft\Craft;
use Craft\Exception;
use Craft\BaseElementModel;

abstract class ActionAbstract
{
    protected $requestType;
    protected $elementType;
    protected $elementId;
    protected $elementAction;
    protected $params;
    protected $transformer;
    protected $error_transformer;
    protected $serializer;
    protected $validator;

    protected $model;
    protected $record;
    protected $attributes = [];
    protected $fields = [];

    public function __construct(Tap $tap)
    {
        $this->requestType       = $tap->requestType;
        $this->elementType       = $tap->elementType;
        $this->elementId         = $tap->elementId;
        $this->elementAction     = $tap->elementAction;
        $this->params            = $tap->params;
        $this->transformer       = $tap->transformer;
        $this->error_transformer = $tap->error_transformer;
        $this->serializer        = $tap->serializer;
        $this->validator         = $tap->validator;

        $this->setModel();
        $this->setRecord();
        $this->setAttributesAndFields();
    }

    abstract public function run();

    public function execute()
    {
        $manager = new Manager();
        $manager->setSerializer(new $this->serializer);

        $results = $this->run();

        return $manager->createData($results)->toArray();
    }

    private function setModel()
    {
        if ($this->elementId) {
            $model = craft()->elements->getElementById($this->elementId, $this->elementType);
        } else {
            $model_class = '\\Craft\\'.$this->elementType.'Model';
            $model = new $model_class();
        }

        if (!$model) {
            throw new Exception(Craft::t('Model not found.'));
        }

        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModelAttributes(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->model->setAttribute($key, $value);
        }
    }

    private function setRecord()
    {
        $record_class = '\\Craft\\'.$this->elementType.'Record';

        if ($this->model->id) {
            $record = $record_class::model()->findById($this->model->id);
        } else {
            $record = new $record_class();
        }

        if (!$record) {
            throw new Exception(Craft::t('Record not found.'));
        }

        $this->record = $record;
    }

    public function getRecord()
    {
        return $this->record;
    }

    public function getElementType()
    {
        $element_type_class = '\\Craft\\'.$this->elementType.'ElementType';
        return new $element_type_class;
    }

    public function validateElement(BaseElementModel $element)
    {
        $this->validator->setElement($element);
        $this->validator->validate();

        if ($this->validator->hasErrors()) {
            return $this->validator->getErrors();
        }

        return null;
    }

    // public function saveElement(BaseElementModel $element)
    // {
    //     $this->validator->setElement($element);
    //     $this->validator->validate();

    //     if ($this->validator->hasErrors()) {
    //         return $this->validator->getErrors();
    //     }

    //     $element_type = $this->getElementType();
    //     return $element_type->saveElement($element, null);
    // }

    private function setAttributesAndFields()
    {
        if (isset($this->params['fields'])) {
            $this->fields = $this->params['fields'];
            unset($this->params['fields']);
        }

        $this->attributes = $this->params;
    }

}

function craft()
{
    return \Craft\craft();
}
