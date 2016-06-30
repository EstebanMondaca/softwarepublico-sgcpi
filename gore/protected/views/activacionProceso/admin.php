<?php

$this->breadcrumbs = array(
	//$model->label(2) => array('index'),
	Yii::t('ui','Preferencias')=>array('/preferencias'),
	Yii::t('app', $model->label(2)),
	//Yii::t('app', 'Index'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('activacion-proceso-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3><?php echo  GxHtml::encode($model->label(2)); ?></h3>




<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'activacion-proceso-grid',
	'dataProvider' => $model->search(),
	'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	//'filter' => $model,
	'columns' => array(
		//'id',
		array(
				'name'=>'periodo_id',
				'value'=>'GxHtml::valueEx($data->periodo)',
				'filter'=>GxHtml::listDataEx(PeriodosProcesos::model()->findAllAttributes(null, true)),
				),
		'nombre_contenedor',
		'inicio',
		'fin',
		array(
			'class' => 'CButtonColumn',
			'template'=>'{update}',
			'afterDelete'=>'function(link,success,data){ if(success)mostrarMensajes(data); }',
			'buttons'=>array(
                        'update'=>
                            array(
                                    'url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey,"idIndicador"=>$data->primaryKey))',
                            		'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                               	  // 'visible'=>'Yii::app()->user->checkAccessChangeDataGore("IndicadoresController",array(),"update")',
                            		// 'visible'=>'Yii::app()->user->checkAccessChange(array("modelName"=>"Indicadores","fieldName"=>"responsable_id","idRow"=>$data->id))',
                             		
                            	),
                         	
                  )
		),
	),
)); ?>