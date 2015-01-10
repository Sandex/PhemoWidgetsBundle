<?php /* @var $this \Phalcon\Mvc\View\EngineInterface */ ?>
<?php /* @var $widget \Phemo\WidgetsBundle\Widget\GridView */ ?>

<?php $pk = $widget->getPrimarykey() ?>

<tbody>
    <?php if ($widget->getTotalRows()): ?>
        <?php foreach ($widget->getData() as $entity): ?>
            <?php /* @var $entity \Phalcon\Mvc\Model */ ?>
            <tr>
                <?php foreach ($widget->getRowValues($entity) as $value): ?>
                    <td><?php echo $value ?></td>
                <?php endforeach; ?>

                <td>
                    <a href="<?php echo $this->url->get('product/view/' . $widget->getPrimarykeyValue($entity)) ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                    <a href="<?php echo $this->url->get('product/edit/' . $widget->getPrimarykeyValue($entity)) ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="<?php echo $this->url->get('product/delete/' . $widget->getPrimarykeyValue($entity)) ?>"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        <?php endforeach ?>
    <?php else: ?>
        <tr>
            <td colspan="<?php echo count($widget->getTotalRows()) + 1 ?>">
                <i><?php echo $this->getDI()->get('t' . $widget->getWidgetName())->_('No results found') ?></i>
            </td>
        </tr>
    <?php endif; ?>
</tbody>