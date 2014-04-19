<?php

namespace Phemo\WidgetsBundle\Widget;

use Phalcon\Exception;
use Phalcon\Text;

class GridView extends BaseListView
{

    private $columns;
    private $attributes;
    private $filters;
    private $fields;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    public function setConfig($params = [])
    {
        if (!isset($params['dataProvider'])) {
            throw new Exception('DataProvider must be defined!');
        }

        $this->setDataProvider($params['dataProvider']);

        $columns = isset($params['columns']) ? $params['columns'] : [];
        $this->setColumns($columns);

        if (isset($params['id'])) {
            $this->setWidgetId($params['id']);
        }
    }

    /**
     * @inheritdoc
     */
    public function getTemplateName()
    {
        return 'main';
    }

    /**
     * @inheritdoc
     */
    public function getWidgetName()
    {
        return 'GridView';
    }

    public function setColumns($columns)
    {
        $this->columns = $columns;

        foreach ($this->columns as $column) {

            if (is_array($column)) {
                if (!isset($column['name'])) {
                    continue;
                }

                $attribute = $column['name'];
                $this->filters[] = $column['filter'];

                if (isset($column['value']) && is_callable($column['value'])) {
                    $this->fields[$attribute] = $column['value'];
                }
            }
            else {
                $attribute = $column;
            }
            $this->attributes[] = $attribute;


            if (!isset($this->fields[$attribute])) {
                $this->fields[$attribute] = $attribute;
            }
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Retrun attributes (camelCased properties)
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Retrun fileds (underscored fileds)
     *
     * @return array
     */
    public function getRowValues($entity)
    {
        $values = [];

        foreach ($this->fields as $attribute => $accessor) {

            if (is_callable($accessor)) {
                $values[] = $accessor($entity);
            }
            else {
                if (is_object($entity)) {
                    $getter = 'get' . Text::camelize($accessor);
                    $values[] = $entity->$getter();
                }
                else {
                    $getter = Text::uncamelize($accessor);
                    $values[] = $entity[$accessor];
                }
            }
        }

        return $values;
    }

    public function getTotalRows()
    {
        return $this->getDataProvider()->getTotalRows();
    }

    public function getOffset()
    {
        return $this->getDataProvider()->getOffset();
    }

    public function getOffsetSize()
    {
        return $this->getDataProvider()->getOffsetSize();
    }

}
