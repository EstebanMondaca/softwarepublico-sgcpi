<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Actualizar'),
);

?>

<h3><?php echo Yii::t('app', 'Actualizar') . ' ' . GxHtml::encode($model->label()); ?></h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model,'modelLA'=>$modelLA));
?>