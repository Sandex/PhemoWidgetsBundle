<?php

namespace Phemo\WidgetsBundle\Service;

use Exception;
use Phalcon\DI\InjectionAwareInterface;

class WidgetFactory implements InjectionAwareInterface
{

    use \Phemo\DiTrait;

    public function create($classname, $params)
    {
        if (!class_exists($classname)) {
            throw new Exception('Class ' . $classname . ' not exists!');
        }

        $class = new $classname($params);
        $class->setDI($this->di);

        return $class;
    }

}
