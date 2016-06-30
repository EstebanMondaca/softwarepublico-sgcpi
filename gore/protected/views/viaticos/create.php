<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Create'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create',
		'titulo'  => Yii::t('app', 'Create') . ' ' . GxHtml::encode($model->label())));

?>