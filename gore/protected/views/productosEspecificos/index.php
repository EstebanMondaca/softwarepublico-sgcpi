<?php

$this->breadcrumbs = array(
    $model->label(1) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
      //  array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
        array('label'=>Yii::t('app', 'Agregar'), 'url'=>array('create')),
    );

?>

<h3><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h3>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'productos-especificos-grid',
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'columns' => array(
        array(
            'header'=>'N°',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        array(
                'name'=>'subproducto_id',
                'value'=>'GxHtml::valueEx($data->subproducto)',
                'filter'=>GxHtml::listDataEx(Subproductos::model()->findAll(array('condition'=>'estado=1'))),
                ),
        'nombre',
        'descripcion',
        'estado',
        array(
            'class' => 'CButtonColumn',
            'afterDelete'=>'function(link,success,data){ if(success)mostrarMensajes(data); }',
            'buttons'=>array(
                        'update'=>
                            array(
                            		'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                            	),
                          'delete'=>
                            array(
                            	'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',                            	
                            ),		
                  ),
        ),
    ),
)); ?>