<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

?>
<div class="form">
<h3>Subproducto</h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'nombre',
'descripcion',
array(
			'name' => 'centroCosto',
			'type' => 'raw',
			'value' => $model->centroCosto ,
			),
array(
			'name' => 'productoEstrategico',
			'type' => 'raw',
			'value' => $model->productoEstrategico ,
			),
	),
)); ?>
</div>

<div class="form">
<h3><?php echo GxHtml::encode($model->getRelationLabel('productosEspecificoses')); ?></h3>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->productosEspecificoses as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::encode(GxHtml::valueEx($relatedModel));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?>
</div>