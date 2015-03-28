<?php
namespace Tap\Actions;

use Craft\Craft;
use Craft\ElementRecord;
use League\Fractal\Resource\Item;

class StoreAction extends ActionAbstract
{
    public function run()
    {
        $record = $this->getRecord();
        $model = $this->getModel();

        $model->validate();

        Craft::dd($model->getErrors());

        return '';
    }
}
