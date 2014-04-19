<?php

namespace Phemo\WidgetsBundle\Widget\DataProvider;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\Model\Exception;

class ModelDataProvider extends AbstractDataProvider
{

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $criteria;

    /**
     * Page size - items on page
     *
     * @var int
     */
    protected $pageSize = 10;

    /**
     * Paginator size
     *
     * @var int
     */
    protected $pagerSize = 5;

    /**
     * Current page num
     *
     * @var int
     */
    protected $currentPage;

    /**
     * @var array
     */
    private $params = [];

    public function __construct($params = [])
    {
        if (is_array($params) && count($params)) {
            $this->setParams($params);
        }
    }

    public function setParams($params = [])
    {
        if (!isset($params['model'])) {
            throw new Exception('Model can not be empty!');
        }
        if (!($params['model'] instanceof Model)) {
            throw new Exception('Model must be instance of \Phalcon\Mvc\Model');
        }

        $this->setModel($params['model']);

        if (isset($params['pageSize'])) {
            $this->setPageSize($params['pageSize']);
        }
        if (isset($params['pagerSize'])) {
            $this->getPagerSize($params['pagerSize']);
        }

        $this->setCriteria(isset($params['criteria']) ? $params['criteria'] : []);


        // get current page
        $request = $this->getDI()->get('request');
        $currentPage = $request->get('page', 'int');

        $this->setCurrentPage($currentPage);
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    public function getCriteria()
    {
        return $this->criteria;
    }

    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }

    public function getPrimaryKey()
    {
        return $this->model->getPrimaryKey();
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage ? $currentPage : 1;

        return $this;
    }

    /**
     * @return array
     */
    private function getParams()
    {
        if ([] === $this->params) {
            if ($this->criteria) {
                $this->params = $this->criteria->getParams();

                $this->currentPage = 1;
            }

            // fetch page
            $this->params['offset'] = $this->getOffset();
            $this->params['limit'] = $this->getPageSize();
            /*
              $this->params = [
              'order'  => 'product_id ASC',
              ];/* */
        }

        return $this->params;
    }

    /**
     *
     * @return array
     */
    protected function fetchData()
    {
        $params = $this->getParams();

        /**
         * @var Simple
         */
        $result = $this->model->find($params);

        return $result;

        /*
          $resultArray = $result->toArray();
          return $resultArray;
         */
    }

    /**
     * Count all records
     *
     * @return int
     */
    public function getTotalRows()
    {
        if (!$this->totalRows) {
            $params = $this->getParams();

            unset($params['offset'], $params['limit']);

            $this->totalRows = $this->model->count($params);
        }

        return (int) $this->totalRows;
    }

    /**
     * Return offset for fetch items
     *
     * @return int
     */
    public function getOffset()
    {
        // calc offset
        $offset = $this->getPageSize() * ($this->currentPage - 1);

        return (int) $offset;
    }

    public function getOffsetSize()
    {
        if ($this->getOffset() + $this->getPageSize() > $this->getTotalRows()) {
            return $this->getTotalRows();
        }

        return (int) $this->getOffset() + $this->getPageSize();
    }

    public function getBeforePage()
    {
        if ($this->currentPage < 2) {
            return $this->currentPage;
        }

        return $this->currentPage - 1;
    }

    public function getNextPage()
    {
        if ($this->currentPage + 1 > $this->getTotalPages()) {
            return $this->currentPage;
        }

        return $this->currentPage + 1;
    }

    public function getTotalPages()
    {
        $totalPages = ceil($this->totalRows / $this->pageSize);
        if (!($this->totalRows % $this->pageSize)) {
            $totalPages--;
        }

        return $totalPages;
    }

    public function setPagerSize($pagerSize)
    {
        $this->pagerSize = $pagerSize;
    }

    public function getPagerSize()
    {
        return $this->pagerSize;
    }

    public function getPagerFrom()
    {
        $pagerFrom = 1;
        $pagerSize = $this->getPagerSize();

        if ($this->getCurrentPage() > $pagerSize - 1) {
            $pagerFrom += $pagerSize - 1;
        }

        return $pagerFrom;
    }

    public function getPagerTo()
    {
        $pagerTo = $this->getPagerSize();

        $pagerTo += $this->getPagerFrom() - 1;

        if ($pagerTo > $this->getTotalPages()) {
            $pagerTo = $this->getTotalPages();
        }

        return $pagerTo;
    }

}
