<?php

$this->breadcrumbs = array(
	Yii::t('ui','Preferencias')=>array('/preferencias'),	
	Yii::t('app', $model->label(2)));

?>

<h1><?php echo GxHtml::encode($model->label(2)); ?></h1>

<div id='criterios' style='float:left;'>
	<span>Criterios:</span>

	<?php
		echo CHtml::dropDownList(
		'criterios',""
		,array('0'=>'Seleccione Criterio')+CHtml::listData($criterios,'id','nombre')
		,array('id'=>'criterio','onchange'=>'mostrarSubCriteriosenElementosDeGestion(criterio.value);')
		);
	?>
</div>
<div id='siguiente' style='float:right:;'>
	<span>Subcriterios:</span>
	<?php
		echo CHtml::dropDownList(
		'subcriterio',""
		,array('0'=>'Seleccione SubCriterio')
		,array('id'=>'subcriterio','onchange'=>'mostrarElementosdeGestion2(criterio.value,subcriterio.value);')
		);
	?>
</div>
<div id="grillaDatos" style='display:none;'>
<div right:>
	<?php $this->widget('zii.widgets.CMenu', array(
                'items'=>array(array('label'=>'Agregar', 'url'=>array('create'))),
                'htmlOptions'=>array('class'=>'MenuOperations','style'=>'display:none;'),
            ));
	?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'elementos-gestion-grid',
	'dataProvider' => $model->search(),
		'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	//'filter' => $model,
	'columns' => array(
		//'id',
		'n_elementogestion',
		//'id_subcriterio',
		//array(
		//		'name'=>'id_subcriterio',
		//		'value'=>'GxHtml::valueEx($data->idSubcriterio)',
		//		'filter'=>GxHtml::listDataEx(Subcriterios::model()->findAll(array('condition'=>'estado=1')))),
		array(
			'name'=>'nombre',
			'value'=>array($this,'gridDataBreakText'),
			'htmlOptions'=>array('width'=>'700px'),
		),
		//'estado',
		array(
			'class' => 'CButtonColumn',
			'template'=>'{update}{delete}',
			'buttons'=>array('update'=>	array('url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey,"idSubcriterio"=>$data->idSubcriterio->primaryKey))',
							'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',),
							'delete'=>	array('imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',),
				),
			'afterDelete'=>'function(link,success,data){ if(success) mostrarMensajes(data); }',
		),
	),
)); ?>
</div>