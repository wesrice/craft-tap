<?php
namespace Tap\Validators;

use Craft\BaseElementModel;
use Craft\BaseRecord;

abstract class ValidatorAbstract
{
    /**
     * Model
     *
     * @var BaseElementModel
     */
    protected $model;

    /**
     * Errors
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Set Model
     *
     * @param BaseElementModel $model Model
     */
    public function setModel(BaseElementModel $model)
    {
        $this->model = $model;
    }

    /**
     * Get Errors
     *
     * @return [type] [description]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Add Error
     *
     * @param string $error Error
     */
    public function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * Has Errors
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return ($this->errors) ? true : false;
    }

    public function validate()
    {
        $this->validateModel();
    }

    /**
     * Validate Model
     *
     * @return void
     */
    private function validateModel()
    {
        return $this->model->validate();
    }
}
