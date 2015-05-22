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
        $model = $this->getModel();

        $this->saveElement($model);

        return new Item($this->model, $this->transformer);
    }
}
