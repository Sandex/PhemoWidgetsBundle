<?php /* @var $this \Phalcon\Mvc\View\EngineInterface */ ?>
<?php /* @var $widget \Phemo\WidgetsBundle\Widget\GridView */ ?>

<div id="<?php echo $widget->getWidgetId() ?>">

    <table class="table table-striped">

        <caption class="summary" style="text-align: right;">
            <?php
            echo $this->getDI()->get('t' . $widget->getWidgetName())->_('Items %item_num_start% &mdash; %item_num_end% from %item_total%', [
                'item_num_start' => $widget->getOffset(),
                'item_num_end'   => $widget->getOffsetSize(),
                'item_total'     => number_format($widget->getTotalRows(), 0, '', ' '),
            ])
            ?>
        </caption>

        <?php $this->partial('_table_head', ['widget' => $widget]) ?>
        <?php $this->partial('_table_body', ['widget' => $widget]) ?>
        <?php $this->partial('_table_foot', ['widget' => $widget]) ?>

    </table>

    <?php if ($widget->getTotalRows()): ?>
        <?php $this->partial('_pagination', ['widget' => $widget]) ?>
    <?php endif ?>
    
</div>


<script type="text/javascript">
    $(function() {
        search('#<?php echo $widget->getWidgetId() ?>');
    });
</script>

<script type="text/javascript">
    function search(el) {
        $(el + ' .filters .form-control').each(function() {
            $(this).bind('change', function() {
                ajaxSearch(el);
            });
        });
    }

    function ajaxSearch(el) {
        var data = {
        };
        $(el + ' .filters input.form-control').each(function() {
            data[$(this).attr('name')] = $(this).val();
        });
        $(el + ' .filters select.form-control').each(function() {
            data[$(this).attr('name')] = $("option:selected", this).val();
        });

        $.ajax({
            type: 'post',
            url: '<?php echo $this->url->get('product/index/') ?>',
            async: true,
            timeout: 15 * 1000,
            data: data,
            success: function(data) {
                $(el).html(data);
            },
            error: function(jqXHR, textStatus, data) {
            },
            beforeSend: function() {
                $(el).css({
                    'opacity': 0.4,
                })
                        .activity({
                            segments: 12,
                            width: 6,
                            space: 10,
                            steps: 3,
                            length: 13,
                            color: '#252525',
                            speed: 3.2
                        });
            },
            complete: function(jqXHR, textStatus) {
                $(el).css('opacity', '1');
            }
        });
    }
</script>