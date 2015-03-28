<?php
namespace Tap\Actions;

use Craft\Craft;
use League\Fractal\Resource\Item;

class ShowAction extends ActionAbstract
{
    public function run()
    {
        $criteria = craft()->elements->getCriteria($this->elementType, $this->params);

        $element = $criteria->first();

        return new Item($element, $this->transformer);
    }
}
