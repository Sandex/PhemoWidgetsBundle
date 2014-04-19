<?php /* @var $this \Phalcon\Mvc\View\EngineInterface */ ?>
<?php /* @var $widget \Phemo\WidgetsBundle\Widget\GridView */ ?>
<tr>
    <?php foreach ($widget->getAttributes() as $attribute): ?>
        <th><?php echo $this->t->_($attribute) ?></th>
    <?php endforeach ?>

    <th><?php echo $this->getDI()->get('t' . $widget->getWidgetName())->_('Actions') ?></th>
</tr>