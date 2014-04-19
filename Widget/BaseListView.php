<?php

namespace Phemo\WidgetsBundle\Widget;

use Phalcon\Text;
use Phemo\WidgetsBundle\Widget\DataProvider\AbstractDataProvider;

class BaseListView extends WidgetView
{

    /**
     * @var AbstractDataProvider
     */
    private $dataProvider;

    /**
     * Constructor BaseListView
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    public function setDataProvider(AbstractDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * @return AbstractDataProvider
     */
    public function getDataProvider()
    {
        return $this->dataProvider;
    }

    public function getData()
    {
        return $this->getDataProvider()->getData();
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
        return 'ListView';
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getDataProvider()->getPrimaryKey();
    }

    /**
     * @param type $entity
     */
    public function getPrimarykeyValue($entity)
    {
        $pk = $this->getPrimaryKey();

        if (is_object($entity)) {
            $getter = 'get' . Text::camelize($pk);
            return $entity->$getter();
        }
        else {
            $getter = Text::uncamelize($pk);
            return $entity[$accessor];
        }
    }

}
