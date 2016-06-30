<?php

/*$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	Yii::t('app', 'Update'),
);*/

?>

<h3>Registro de jornada de evaluación anual</h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>