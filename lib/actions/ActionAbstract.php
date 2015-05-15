<?php
namespace Tap\Actions;

use Tap\Request;
use League\Fractal\Manager;
use Craft\Craft;
use Craft\Exception;
use Craft\BaseElementModel;
use Craft\BaseRecord;

abstract class ActionAbstract
{
    protected $request;

    protected $model;
    protected $record;
    protected $attributes = [];
    protected $fields = [];

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->setModel();
        $this->setRecord();
        $this->setAttributesAndFields();
    }

    abstract public function run();

    public function execute()
    {
        return $this->run();
    }

    private function setModel()
    {
        if ($this->request->elementId) {
            $model = craft()->elements->getElementById($this->request->elementId, $this->request->elementType);
        } else {
            $model_class = '\\Craft\\'.$this->request->elementType.'Model';
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

    private function setRecord()
    {
        $record_class = '\\Craft\\'.$this->request->elementType.'Record';

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

    public function setAttributes($object, array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $object->setAttribute($key, $value);
        }

        return $object;
    }

    public function getElementType()
    {
        $element_type_class = '\\Craft\\'.$this->request->elementType.'ElementType';
        return new $element_type_class;
    }

    public function validate(BaseElementModel $model)
    {
        $this->request->validator->setModel($model);

        $this->request->validator->validate();
    }

    public function saveElement(BaseElementModel $model)
    {
        $this->validate($model);

        if ($this->request->validator->hasErrors()) {
            throw new Exception('There are errors.');
        }

        $element_type = $this->getElementType();

        if (!$element_type->saveElement($this->model, null)) {
            throw new Exception('Element could not be saved.');
        }
    }

    private function setAttributesAndFields()
    {
        if (isset($this->request->params['fields'])) {
            $this->fields = $this->params['fields'];
            unset($this->request->params['fields']);
        }

        $this->attributes = $this->request->params;
    }

}

function craft()
{
    return \Craft\craft();
}
