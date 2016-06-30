<?php
/* @var $this MisionesVisionesController */
/* @var $model MisionesVisiones */

$this->breadcrumbs=array(
	'Misiones Visiones'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List MisionesVisiones', 'url'=>array('index')),
	array('label'=>'Create MisionesVisiones', 'url'=>array('create')),
	array('label'=>'View MisionesVisiones', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MisionesVisiones', 'url'=>array('admin')),
);*/
?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'titulo'=>'Editar '.$model->nombre)); ?>