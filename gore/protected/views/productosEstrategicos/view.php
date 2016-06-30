<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

?>

<div class="form">

<?php 
echo "<h3>".GxHtml::encode('Producto Estratégico '.$model->tipoProducto)."</h3>"; 
$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(

array(
			'name' => 'division',
			'type' => 'raw',
			'value' => $model->division,
			),
'nombre',
'descripcion',
array(
            'name' => 'gestion_territorial',
            'type' => 'raw',
            'value' => $model->gestion_territorial == 1 ? "Si":"No",
            ),
'gestion_territorial_descripcion',  
array(
            'name' => 'desagregado_sexo',
            'type' => 'raw',
            'value' => $model->desagregado_sexo == 1 ? "Si":"No",
            ),
'desagregado_sexo_descripcion',
	),
)); ?>

</div>

<div class="form">
<h3><?php echo GxHtml::encode($model->getRelationLabel('objetivosEstrategicoses')); ?></h3>

<?php
	echo GxHtml::openTag('ul');
	foreach($model->objetivosEstrategicoses as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::encode(GxHtml::valueEx($relatedModel));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?>
</div>
<div class="form">
<h3><?php echo GxHtml::encode($model->getRelationLabel('clientes'))." ".$model->tipoProducto; ?></h3>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->clientes as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::encode(GxHtml::valueEx($relatedModel));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?>
</div>
