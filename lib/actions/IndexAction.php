<?php
namespace Tap\Actions;

use Craft\Craft;
use League\Fractal\Resource\Collection;

class IndexAction extends ActionAbstract
{
    public function run()
    {
        $criteria = craft()->elements->getCriteria($this->elementType, $this->params);

        $elements = $criteria->find();

        return new Collection($elements, $this->transformer);
    }
}
