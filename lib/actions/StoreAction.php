<?php
namespace Tap\Actions;

use Craft\Craft;
use Craft\ElementRecord;
use League\Fractal\Resource\Item;
use Craft\Exception;

class StoreAction extends ActionAbstract
{
    public function run()
    {
        $this->setModelAttributes($this->params);

        $element = $this->getModel();

        if ($errors = $this->validateElement($element)) {
            return new Item((object) $errors, $this->error_transformer);
        }

        $element_type = $this->getElementType();

        try {
            if (!$element_type->saveElement($element, null)) {
                throw new Exception('Element could not be saved.');
            }
        } catch (Exception $exception) {
           return new Item((object) [$exception->getMessage()], $this->error_transformer);
        }

        return new Item($element, $this->transformer);
    }
}
