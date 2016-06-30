<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	Yii::t('app', 'Update'),
);

     
?>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
        'modelProductosEspecificos'=>$modelProductosEspecificos,'titulo'=>Yii::t('app', 'Update') . ' ' . GxHtml::encode($model->label(1))));
?>