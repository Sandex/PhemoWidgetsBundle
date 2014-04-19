<?php /* @var $this \Phalcon\Mvc\View\EngineInterface */ ?>
<?php /* @var $widget \Phemo\WidgetsBundle\Widget\GridView */ ?>

<div>
    <ul class="pagination">
        <li>
            <a href="<?php echo $this->url->get('product/index/') ?>">
                <?php echo $this->getDI()->get('t' . $widget->getWidgetName())->_('First') ?>
            </a>
        </li>
        <li>
            <a href="<?php echo $this->url->get('product/index/') . '?' . http_build_query(['page' => $widget->getDataProvider()->getBeforePage()]) ?>">
                <?php echo $this->getDI()->get('t' . $widget->getWidgetName())->_('Prev') ?>
            </a>
        </li>

        <?php for ($i = $widget->getDataProvider()->getPagerFrom(); $i <= $widget->getDataProvider()->getPagerTo(); $i++): ?>
            <?php if ($widget->getDataProvider()->getCurrentPage() == $i): ?>
                <li class="active">
            <?php else: ?>
                <li>
            <?php endif; ?>

                <?php
                echo $this->tag->linkTo([
                    'product/index/' . '?' . http_build_query(['page' => $i]),
                    $i,
                    'class' => ($widget->getDataProvider()->getCurrentPage() == $i ? 'active' : ''),
                ])
                ?>
            </li>
        <?php endfor; ?>

        <li>
            <a href="<?php echo $this->url->get('product/index/') . '?' . http_build_query(['page' => $widget->getDataProvider()->getNextPage()]) ?>">
                <?php echo $this->getDI()->get('t' . $widget->getWidgetName())->_('Next') ?>
            </a>
        </li>
        <li>
            <a href="<?php echo $this->url->get('product/index/') . '?' . http_build_query(['page' => $widget->getDataProvider()->getTotalPages()]) ?>">
                <?php echo $this->getDI()->get('t' . $widget->getWidgetName())->_('Last') ?>
            </a>
        </li>
    </ul>
</div>