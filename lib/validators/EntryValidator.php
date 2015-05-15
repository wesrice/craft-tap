<?php
namespace Tap\Validators;

use Craft\BaseElementModel;
use Craft\Craft;

class EntryValidator extends ValidatorAbstract
{
    public function validate()
    {
        $this->validateModel();
        $this->hasSectionId();
    }

    private function validateModel()
    {
        $attributes = $this->element->getAttributes();

        return $this->element->validate($attributes);
    }

    private function hasSectionId() {
        if (!in_array('sectionId', $this->element->attributeNames())) {
            return $this->addError('The `sectionId` is required.');
        }
    }
}
