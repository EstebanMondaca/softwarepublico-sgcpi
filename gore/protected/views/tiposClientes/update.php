<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	Yii::t('app', 'Update'),
);

$this->renderPartial('_form', array(
		'model' => $model,
		'titulo'=>Yii::t('app', 'Update') . ' ' . GxHtml::encode($model->label())
	));
?>