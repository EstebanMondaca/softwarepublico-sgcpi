<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Create'),
);

/*$this->menu = array(
	array('label'=>Yii::t('app', 'Volver') . ' ' . $model->label(2), 'url' => array('index')),
);*/
?>

<h3><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($model->label()); ?></h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>