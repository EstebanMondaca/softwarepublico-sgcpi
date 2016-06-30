<?php

$this->breadcrumbs = array(
    Yii::t('ui','Preferencias')=>array('/preferencias'),    
    Yii::t('app', $model->label(2)),
);

$this->widget('zii.widgets.CMenu', array(
                    'items'=>array(array('label'=>'Agregar', 'url'=>array('create'))),
                    'htmlOptions'=>array('class'=>'MenuOperations'),
                ));


?>

<h3><?php echo GxHtml::encode($model->label(2)); ?></h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cargos-grid',
    'dataProvider' => $model->search(),
    'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',    
    'columns' => array(
        array(
            'header'=>'N°',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        'nombre',        
        array(
            'class' => 'CButtonColumn',
            'template'=>'{update}{delete}',
            'header' => 'Acciones',
            'buttons'=>array('update'=> array('url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey))',
                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',),
                        'delete'=>  array('imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',),
                ),
            'afterDelete'=>'function(link,success,data){ if(success) mostrarMensajes(data); }',
        ),
    ),
)); ?>