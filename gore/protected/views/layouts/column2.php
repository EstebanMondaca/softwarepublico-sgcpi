<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

	
<div class="span-24">
    <div id="content">
        <?php
        /*  $this->beginWidget('zii.widgets.CPortlet', array(
                //'title'=>'Operaciones',
            ));*/
            $this->widget('zii.widgets.CMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'MenuOperations'),
            ));
            //$this->endWidget();
        ?>
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<?php $this->endContent(); ?>