<?php

namespace Phemo\WidgetsBundle\Widget;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Mvc\View;
use Phalcon\Text;
use Phalcon\Translate\Adapter\NativeArray;

abstract class WidgetView implements InjectionAwareInterface
{

    use \Phemo\DiTrait;

    private $widgetId;

    /**
     * Return widget name
     *
     * @return string
     */
    abstract public function getWidgetName();

    /**
     * Return main template name
     *
     * @return string
     */
    abstract public function getTemplateName();

    /**
     * Constructor WidgetView
     *
     * @param array $params
     */
    public function __construct($params = [])
    {
        if (is_array($params) && count($params)) {
            $this->setConfig($params);
        }

        if (!$this->widgetId) {
            $widgetId = uniqid(
                'phw_' . Text::uncamelize($this->getWidgetName()) . '_'
            );
            $this->setWidgetId($widgetId);
        }
    }

    public function getWidgetId()
    {
        return $this->widgetId;
    }

    public function setWidgetId($widgetId)
    {
        $this->widgetId = $widgetId;
    }

    public function getWidgetTemplateDir()
    {
        $dir = __DIR__ . '/Resources/templates/' . $this->getWidgetName() . DIRECTORY_SEPARATOR;

        return $dir;
    }

    public function getWidgetTranslationDir()
    {
        $i13n = $this->getDI()->getShared('i13n');

        $dir = __DIR__ . '/Resources/translations/' . $this->getWidgetName() . DIRECTORY_SEPARATOR . $i13n . '/messages.php';

        return $dir;
    }

    /**
     * Render widget view
     */
    public function render()
    {
        $vars = [
            'widget' => $this,
        ];

        $this->setWidgetTranslator();

        $this->renderTemplate($this->getWidgetTemplateDir(), $this->getTemplateName(), $vars);
    }

    /**
     * Render view
     *
     * @param string $dir
     * @param string $templateName
     * @param array $vars
     */
    private function renderTemplate($dir, $templateName, $vars = [])
    {
        /* @var $view View */
        $view = $this->getDI()->get('view');

        $view->registerEngines([
            '.html.php' => '\Phalcon\Mvc\View\Engine\Php',
        ]);
        $view->setViewsDir($dir);

        $view->partial($templateName, $vars);
        $view->disable();
    }

    /**
     *
     */
    private function setWidgetTranslator()
    {
        $this->getDI()->setShared('t' . $this->getWidgetName(), function() {
            $messages = [];

            $translationFile = $this->getWidgetTranslationDir();

            // Check translation file exists
            if (file_exists($translationFile)) {
                $messages = require_once $translationFile;
            }

            return new NativeArray([
                'content' => $messages,
            ]);
        });
    }

}
