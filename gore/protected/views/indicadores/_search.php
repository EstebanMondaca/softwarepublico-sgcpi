<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'frecuencia_control_id'); ?>
		<?php echo $form->dropDownList($model, 'frecuencia_control_id', GxHtml::listDataEx(FrecuenciasControles::model()->findAll(array('condition'=>'estado=1'))), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'unidad_id'); ?>
		<?php echo $form->dropDownList($model, 'unidad_id', GxHtml::listDataEx(Unidades::model()->findAll(array('condition'=>'estado=1'))), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'clasificacion_tipo_id'); ?>
		<?php echo $form->dropDownList($model, 'clasificacion_tipo_id', GxHtml::listDataEx(ClasificacionesTipos::model()->findAll(array('condition'=>'estado=1'))), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'producto_especifico_id'); ?>
		<?php echo $form->dropDownList($model, 'producto_especifico_id', GxHtml::listDataEx(ProductosEspecificos::model()->findAll(array('condition'=>'estado=1'))), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'tipo_formula_id'); ?>
		<?php echo $form->dropDownList($model, 'tipo_formula_id', GxHtml::listDataEx(TiposFormulas::model()->findAll(array('condition'=>'estado=1'))), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'clasificacion_dimension_id'); ?>
		<?php echo $form->dropDownList($model, 'clasificacion_dimension_id', GxHtml::listDataEx(ClasificacionesDimensiones::model()->findAll(array('condition'=>'estado=1'))), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'clasificacion_ambito_id'); ?>
		<?php echo $form->dropDownList($model, 'clasificacion_ambito_id', GxHtml::listDataEx(ClasificacionesAmbitos::model()->findAll(array('condition'=>'estado=1'))), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'nombre'); ?>
		<?php echo $form->textField($model, 'nombre', array('maxlength' => 200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'ascendente'); ?>
		<?php echo $form->textField($model, 'ascendente'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'conceptoa'); ?>
		<?php echo $form->textArea($model, 'conceptoa'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'conceptob'); ?>
		<?php echo $form->textArea($model, 'conceptob'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'conceptoc'); ?>
		<?php echo $form->textArea($model, 'conceptoc'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'formula'); ?>
		<?php echo $form->textArea($model, 'formula'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'medio_verificacion'); ?>
		<?php echo $form->textArea($model, 'medio_verificacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'notas'); ?>
		<?php echo $form->textArea($model, 'notas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'efectivot3'); ?>
		<?php echo $form->textField($model, 'efectivot3', array('maxlength' => 200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'efectivot2'); ?>
		<?php echo $form->textField($model, 'efectivot2', array('maxlength' => 200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'efectivot1'); ?>
		<?php echo $form->textField($model, 'efectivot1', array('maxlength' => 200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'meta_anual'); ?>
		<?php echo $form->textField($model, 'meta_anual', array('maxlength' => 200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'meta_parcial'); ?>
		<?php echo $form->textField($model, 'meta_parcial', array('maxlength' => 200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'supuestos'); ?>
		<?php echo $form->textArea($model, 'supuestos'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
