<?php
/* @var $this MisionesVisionesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Misiones Visiones',
);

/*$this->menu=array(
	array('label'=>'Create MisionesVisiones', 'url'=>array('create')),
	array('label'=>'Manage MisionesVisiones', 'url'=>array('admin')),
);
 */
?>


<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	'summaryText'=>''	
)); ?>
