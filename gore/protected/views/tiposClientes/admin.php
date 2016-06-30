<?php

$this->breadcrumbs = array(
	Yii::t('ui','Preferencias')=>array('/site/preferencias'),	
	Yii::t('app', $model->label(2)));
?>

<h3><?php echo GxHtml::encode($model->label(2)); ?></h3>
<div right:>
<?php 
	$this->widget('zii.widgets.CMenu', array(
          'items'=>array(array('label'=>'Agregar', 'url'=>array('create'))),
          'htmlOptions'=>array('class'=>'MenuOperations'),
      ));
?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'tipos-clientes-grid',
	'dataProvider' => $model->search(),
		'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	//'filter' => $model,
	'columns' => array(
		//'id',
		array(
			'header'=>'N°',
			'htmlOptions'=>array('width'=>'30'),
			'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
		),
		'nombre',
		//'estado',
		array(
			'class' => 'CButtonColumn',
			'afterDelete'=>'function(link,success,data){ if(success) mostrarMensajes(data); }',
		),
	),
)); ?>