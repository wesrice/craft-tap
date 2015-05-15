<?php
namespace Tap\Validators;

use Craft\BaseElementModel;

abstract class ValidatorAbstract
{
    protected $errors;

    public function __construct()
    {
        // $this->validate();
    }

    abstract public function validate();

    public function setElement(BaseElementModel $element)
    {
        $this->element = $element;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function hasErrors()
    {
        return ($this->errors) ? true : false;
    }
}
