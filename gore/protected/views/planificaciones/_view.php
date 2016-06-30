<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('estado_planificacion_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->estadoPlanificacion)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('periodo_proceso_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->periodoProceso)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('nombre')); ?>:
	<?php echo GxHtml::encode($data->nombre); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('descripcion')); ?>:
	<?php echo GxHtml::encode($data->descripcion); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('mision_vision_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->misionVision)); ?>
	<br />

</div>