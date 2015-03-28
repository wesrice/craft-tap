<?php
namespace Tap\Actions;

use Craft\Craft;
use League\Fractal\Resource\Item;

class DestroyAction extends ActionAbstract
{
    public function run()
    {
        return craft()->elements->deleteElementById($this->elementId);
    }
}
