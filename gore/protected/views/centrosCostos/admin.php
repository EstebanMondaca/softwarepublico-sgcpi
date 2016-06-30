<?php

$this->breadcrumbs = array(
	//$model->label(2) => array('index'),
	Yii::t('ui','Preferencias')=>array('/preferencias'),	
	Yii::t('app', $model->label(2)),
);
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
	'id' => 'centros-costos-grid',
	'dataProvider' => $model->search(),
	'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	//wmulchy 'filter' => $model,
	'columns' => array(
		//'id',
		array(
			'header'=>'N°',
			'htmlOptions'=>array('width'=>'30'),
			'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
		),
		array(
			'name'=>'division_id',
			'value'=>'GxHtml::valueEx($data->division)',
			'filter'=>GxHtml::listDataEx(Divisiones::model()->findAll(array('condition'=>'estado=1'))),
		),
		array(
			'name'=>'nombre',
			'value'=>array($this,'gridDataBreakText'),
			'htmlOptions'=>array('width'=>'170px'),
			),
		array(
			'name'=>'descripcion',
			'value'=>array($this,'gridDataBreakText2'),
			'htmlOptions'=>array('width'=>'500px'),
		),
		//'estado',
		array(
			'class' => 'CButtonColumn',
			'template'=>'{update}{delete}',
			'header' => 'Acciones',
			'buttons'=>array('update'=>	array('url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey))',
						'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',),
						'delete'=>	array('imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',),
				),
			'afterDelete'=>'function(link,success,data){ if(success) mostrarMensajes(data); }',
		),
	),
)); ?>