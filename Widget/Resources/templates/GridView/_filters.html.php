<?php /* @var $this \Phalcon\Mvc\View\EngineInterface */ ?>
<?php /* @var $widget \Phemo\WidgetsBundle\Widget\GridView */ ?>
<tr class="filters">
    <?php foreach ($widget->getFilters() as $filter): ?>
        <td>
            <div class="form-group">
                <?php echo $filter ?>
            </div>
        </td>
    <?php endforeach ?>

    <td><!-- Actions dummy --></td>
</tr>