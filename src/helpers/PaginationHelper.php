<?php
namespace Tap\Helpers;

use Craft\craft;
use Craft\ElementCriteriaModel;
use Craft\PaginateVariable;

class PaginationHelper
{
    public static function paginateCriteria(ElementCriteriaModel $criteria)
    {
        $currentPage = isset($criteria->page) ? $criteria->page : 1;
        $limit = $criteria->limit;
        $total = $criteria->total() - $criteria->offset;
        $totalPages = ceil($total / $limit);

        $paginateVariable = new PaginateVariable();

        if ($totalPages == 0) {
            return array($paginateVariable, array());
        }

        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        $offset = $limit * ($currentPage - 1);

        // Is there already an offset set?
        if ($criteria->offset) {
            $offset += $criteria->offset;
        }

        $last = $offset + $limit;

        if ($last > $total) {
            $last = $total;
        }

        $paginateVariable->first       = (int) $offset + 1;
        $paginateVariable->last        = (int) $last;
        $paginateVariable->total       = (int) $total;
        $paginateVariable->currentPage = (int) $currentPage;
        $paginateVariable->totalPages  = (int) $totalPages;
        $paginateVariable->perPage     = (int) $limit;

        // Copy the criteria, set the offset, and get the elements
        $criteria = $criteria->copy();
        $criteria->offset = $offset;
        $elements = $criteria->find();

        return array($paginateVariable, $elements);
    }
}

function craft()
{
    return \Craft\craft();
}
