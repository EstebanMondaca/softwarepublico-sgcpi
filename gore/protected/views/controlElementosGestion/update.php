<?php

$this->breadcrumbs = array(
	'Selección elemento gestión' => array('index'),
	'Registro Evidencia Control de Gestión',
);
$this->renderPartial('_form', array(
		'model' => $model,
		'titulo'=>'Registro Evidencia Control de Gestión'
	));
?>