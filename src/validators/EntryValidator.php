<?php
namespace Tap\Validators;

use Craft\BaseElementModel;
use Craft\Craft;

class EntryValidator extends ValidatorAbstract
{
    /**
     * Validate
     *
     * @return void
     */
    public function validate()
    {
        parent::validate();

        $this->hasSectionId();
    }

    /**
     * Has Section ID
     *
     * @return boolean
     */
    private function hasSectionId() {
        if (!$this->model->getAttribute('sectionId')) {
            $this->addError('The `sectionId` is required.');
        }
    }
}
