<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('id_elemento_gestion')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->idElementoGestion)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('id_planificacion')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->idPlanificacion)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('estado')); ?>:
	<?php echo GxHtml::encode($data->estado); ?>
	<br />

</div>