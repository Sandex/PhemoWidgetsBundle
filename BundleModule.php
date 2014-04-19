<?php

namespace Phemo\WidgetsBundle;

use Phalcon\DI;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phemo\WidgetsBundle\Service\WidgetFactory;

class BundleModule implements ModuleDefinitionInterface
{

    use \Phemo\DiTrait;

    public function registerAutoloaders($di)
    {

    }

    public function registerServices($di)
    {

    }

    /**
     * Even if bundle not load as module
     * this services will be registered
     *
     * @param DI $di
     */
    public static function registerServicesBundle($di)
    {
        // Register the service
        $di->set('widget', new WidgetFactory);
    }

}
