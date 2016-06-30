<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('frecuencia_control_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->frecuenciaControl)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('unidad_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->unidad)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('clasificacion_tipo_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->clasificacionTipo)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('producto_especifico_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->productoEspecifico)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('tipo_formula_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->tipoFormula)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('clasificacion_dimension_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->clasificacionDimension)); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('clasificacion_ambito_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->clasificacionAmbito)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('nombre')); ?>:
	<?php echo GxHtml::encode($data->nombre); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('ascendente')); ?>:
	<?php echo GxHtml::encode($data->ascendente); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('conceptoa')); ?>:
	<?php echo GxHtml::encode($data->conceptoa); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('conceptob')); ?>:
	<?php echo GxHtml::encode($data->conceptob); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('conceptoc')); ?>:
	<?php echo GxHtml::encode($data->conceptoc); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('formula')); ?>:
	<?php echo GxHtml::encode($data->formula); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('medio_verificacion')); ?>:
	<?php echo GxHtml::encode($data->medio_verificacion); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('notas')); ?>:
	<?php echo GxHtml::encode($data->notas); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('efectivot3')); ?>:
	<?php echo GxHtml::encode($data->efectivot3); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('efectivot2')); ?>:
	<?php echo GxHtml::encode($data->efectivot2); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('efectivot1')); ?>:
	<?php echo GxHtml::encode($data->efectivot1); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('meta_anual')); ?>:
	<?php echo GxHtml::encode($data->meta_anual); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('meta_parcial')); ?>:
	<?php echo GxHtml::encode($data->meta_parcial); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('supuestos')); ?>:
	<?php echo GxHtml::encode($data->supuestos); ?>
	<br />
	*/ ?>

</div>