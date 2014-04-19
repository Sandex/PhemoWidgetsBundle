<?php

namespace Phemo\WidgetsBundle\Widget\DataProvider;

use Phalcon\DI\InjectionAwareInterface;

abstract class AbstractDataProvider implements InjectionAwareInterface
{

    use \Phemo\DiTrait;

    private $data;

    /**
     * Total items
     *
     * @var int
     */
    protected $totalRows;

    /**
     * Return data
     *
     * @return array
     */
    abstract protected function fetchData();

    /**
     * Return total num rows in source
     *
     * @return array
     */
    abstract public function getTotalRows();

    /**
     * Return primary key name
     *
     * @return string
     */
    abstract public function getPrimaryKey();

    /**
     * Return prepared data for vidget
     *
     * @return array
     */
    public function getData()
    {
        if (null === $this->data) {
            $this->data = $this->fetchData();
        }

        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

}
