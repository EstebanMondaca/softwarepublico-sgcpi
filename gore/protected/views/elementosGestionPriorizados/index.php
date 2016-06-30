<?php

$this->breadcrumbs = array(
	'Elementos de Gestión Priorizados'
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Agregar') . ' ' . ElementosGestionPriorizados::label(), 'url' => array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . ElementosGestionPriorizados::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(ElementosGestionPriorizados::label(2)); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 