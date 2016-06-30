<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
		array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('planificaciones-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h3>

<p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'planificaciones-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'id',
		array(
				'name'=>'estado_planificacion_id',
				'value'=>'GxHtml::valueEx($data->estadoPlanificacion)',
				'filter'=>GxHtml::listDataEx(EstadosPlanificaciones::model()->findAllAttributes(null,true)),
				),
		array(
				'name'=>'periodo_proceso_id',
				'value'=>'GxHtml::valueEx($data->periodoProceso)',
				'filter'=>GxHtml::listDataEx(PeriodosProcesos::model()->findAllAttributes(null,true)),
				),
		'nombre',
		'descripcion',
		array(
				'name'=>'mision_vision_id',
				'value'=>'GxHtml::valueEx($data->misionVision)',
				'filter'=>GxHtml::listDataEx(MisionesVisiones::model()->findAllAttributes(null,true)),
				),
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>