<?php
namespace Tap\Actions;

use Craft\Craft;
use League\Fractal\Resource\Item;

class ShowAction extends ActionAbstract
{
    public function run()
    {
        $criteria = craft()->elements->getCriteria($this->request->elementType, $this->request->params);

        return $criteria->first();
    }
}
