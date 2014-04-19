<?php /* @var $this \Phalcon\Mvc\View\EngineInterface */ ?>
<?php /* @var $widget \Phemo\WidgetsBundle\Widget\GridView */ ?>

<thead>
    <?php $this->partial('_labels', ['widget' => $widget]) ?>
    <?php $this->partial('_filters', ['widget' => $widget]) ?>
</thead>