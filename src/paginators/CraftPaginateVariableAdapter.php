<?php
namespace Tap\Paginators;

use League\Fractal\Pagination\PaginatorInterface;
use Craft\PaginateVariable;

class CraftPaginateVariableAdapter implements PaginatorInterface
{
    /**
     * Paginate Variable
     *
     * @var Craft\PaginateVariable
     */
    protected $paginateVariable;

    /**
     * Constructor
     *
     * @param PaginateVariable $paginateVariable
     *
     * @return void
     */
    public function __construct(PaginateVariable $paginateVariable)
    {
        $this->paginateVariable = $paginateVariable;
    }

    /**
     * Get the current page.
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->paginateVariable->currentPage;
    }

    /**
     * Get the last page.
     *
     * @return int
     */
    public function getLastPage()
    {
        return $this->paginateVariable->last;
    }

    /**
     * Get the total.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->paginateVariable->totalPages;
    }

    /**
     * Get the count.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->paginateVariable->count;
    }

    /**
     * Get the number per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return $this->paginateVariable->perPage;
    }

    /**
     * Get the url for the given page.
     *
     * @param int $page
     *
     * @return string
     */
    public function getUrl($page)
    {
        return $this->paginateVariable->getPageUrl($page);
    }

    /**
     * Get the paginate variable instance.
     *
     * @return Craft\PaginateVariable
     */
    public function getPaginateVariable()
    {
        return $this->paginateVariable;
    }
}
