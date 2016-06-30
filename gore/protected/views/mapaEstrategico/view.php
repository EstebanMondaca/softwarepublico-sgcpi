
<div class="form">
<h3>Desafío Estratégico</h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
array(
			'name' => 'perspectivaEstrategica',
			'type' => 'raw',
			'value' => $model->perspectivaEstrategica,
			),
array(
			'name' => 'planificacion',
			'type' => 'raw',
			'value' => $model->planificacion,
			),
'nombre',
'descripcion',
            array(
                'label'=>'Objetivos Estratégicos<br><label style="font-size: 10px;">Productos Estratégicos</label>',
                'type' => 'raw',
                'value' => $model->relatedObjetivosEstrategicos,
            ),
	),
)); ?>
</div>
