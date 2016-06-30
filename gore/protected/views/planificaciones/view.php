<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
array(
			'name' => 'estadoPlanificacion',
			'type' => 'raw',
			'value' => $model->estadoPlanificacion !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->estadoPlanificacion)), array('estadosPlanificaciones/view', 'id' => GxActiveRecord::extractPkValue($model->estadoPlanificacion, true))) : null,
			),
array(
			'name' => 'periodoProceso',
			'type' => 'raw',
			'value' => $model->periodoProceso !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->periodoProceso)), array('periodosProcesos/view', 'id' => GxActiveRecord::extractPkValue($model->periodoProceso, true))) : null,
			),
'nombre',
'descripcion',
array(
			'name' => 'misionVision',
			'type' => 'raw',
			'value' => $model->misionVision !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->misionVision)), array('misionesVisiones/view', 'id' => GxActiveRecord::extractPkValue($model->misionVision, true))) : null,
			),
	),
)); ?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('desafiosEstrategicoses')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->desafiosEstrategicoses as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('desafiosEstrategicos/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?>