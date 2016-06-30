<?php

$this->breadcrumbs = array(
	Yii::t('ui','Preferencias')=>array('/preferencias'),	
	Yii::t('app', $model->label(2)),
);
?>

<h3><?php echo GxHtml::encode($model->label(2)); ?></h3>
<?php 
$this->widget('zii.widgets.CMenu', array(
                'items'=>array(array('label'=>'Agregar', 'url'=>array('create'))),
                'htmlOptions'=>array('class'=>'MenuOperations'),
            ));
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'criterios-grid',
	'dataProvider' => $model->search(),
		'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	//'filter' => $model,
	'columns' => array(
		//'id',
		'n_criterio',
		array(
			'name'=>'nombre',
			'value'=>array($this,'gridDataBreakText'),
			'htmlOptions'=>array('width'=>'750px'),
		),
		//'descripcion',
		//'estado',
		array(
			'class' => 'CButtonColumn',
			'template'=>'{update}{delete}',
			'buttons'=>array('update'=>	array('url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey))',
						'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',),
						'delete'=>	array('imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',),
				),
			'afterDelete'=>'function(link,success,data){ if(success) mostrarMensajes(data); }',
		),
	),
)); ?>