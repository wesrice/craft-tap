<?php
namespace Tap\Actions;

use Craft\Craft;
use Tap\Helpers\PaginationHelper;
use League\Fractal\Resource\Collection;


class IndexAction extends ActionAbstract
{
    public function run()
    {
        $criteria = craft()->elements->getCriteria($this->request->elementType, $this->request->params);

        $results = PaginationHelper::paginateCriteria($criteria);

        return $results;
    }
}
