<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);


?>
<div class="form">
<h3>Objetivo Estratégico</h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
array(
			'name' => 'perspectivaEstrategica',
			'type' => 'raw',
			'value' => $model->perspectivaEstrategica ,
			),
'nombre',
'descripcion',
        array(
                'label'=>'Productos Estratégicos',
                'type' => 'raw',
                'value' => $model->relatedProductosEstrategicos,
            ),
	),
)); ?>


</div>