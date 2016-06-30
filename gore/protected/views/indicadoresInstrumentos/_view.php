<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('id_indicador')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->idIndicador)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('id_instrumento')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->idInstrumento)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('ponderacion')); ?>:
	<?php echo GxHtml::encode($data->ponderacion); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('estado')); ?>:
	<?php echo GxHtml::encode($data->estado); ?>
	<br />

</div>