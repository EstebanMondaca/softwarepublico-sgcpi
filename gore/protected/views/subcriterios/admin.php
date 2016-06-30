<?php

$this->breadcrumbs = array(
	Yii::t('ui','Preferencias')=>array('/preferencias'),
	$model->label(2)
);
?>
<h1> <?php echo GxHtml::encode($model->label(2)); ?> </h1>
<div id='criterios' align="justify">
	<div left:>
	<span>Criterios:</span>
	<?php
		echo CHtml::dropDownList(
		'criterios',""
		,array('0'=>'-Por favor seleccione-')+CHtml::listData($criterios,'id','nombre')
		,array('id'=>'criterios','onchange'=>'mostrarSubcriterios2(this.value);')
		);
	?>
	</div>

</div>

<div id="grillaDatos" style='display:none;'>
<div right:>
	<?php 
		$this->widget('zii.widgets.CMenu', array(
               'items'=>array(array('label'=>'Agregar', 'url'=>array('create'))),
               'htmlOptions'=>array('class'=>'MenuOperations','style'=>'display:none;'),
           ));
	?>
</div>
	
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'subcriterios-grid',
	'dataProvider' => $model->search(),
	//'filter' => $model,
	//'summaryText' => false,
	'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	'columns' => array(
		//'id',
		//'id_criterio',
		'n_subcriterio',
		array(
			'name'=>'nombre',
			'value'=>array($this,'gridDataBreakText'),
			'htmlOptions'=>array('width'=>'500px'),
		),
		//'descripcion',
		'cantidad_elementos',
		'factor',
		'puntaje_elemento',
		//'estado',
		array(
			'class' => 'CButtonColumn',
			'template'=>'{update}{delete}',
			'buttons'=>array('update'=>	array('url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey,"idCriterio"=>$data->idCriterio->primaryKey))',
							'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',),
							'delete'=>	array('imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',),
				),
			'afterDelete'=>'function(link,success,data){ if(success) mostrarMensajes(data); }',
		),
	),
)); ?>
</div>

