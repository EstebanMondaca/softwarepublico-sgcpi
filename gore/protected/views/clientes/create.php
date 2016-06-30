<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Create'),
);

$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create',
		'titulo'=>Yii::t('app', 'Create') . ' ' . GxHtml::encode($model->label())
		));
?>