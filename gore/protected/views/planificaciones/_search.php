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
		<?php echo $form->label($model, 'estado_planificacion_id'); ?>
		<?php echo $form->dropDownList($model, 'estado_planificacion_id', GxHtml::listDataEx(EstadosPlanificaciones::model()->findAllAttributes(null,true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'periodo_proceso_id'); ?>
		<?php echo $form->dropDownList($model, 'periodo_proceso_id', GxHtml::listDataEx(PeriodosProcesos::model()->findAllAttributes(null,true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'nombre'); ?>
		<?php echo $form->textField($model, 'nombre', array('maxlength' => 200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'descripcion'); ?>
		<?php echo $form->textArea($model, 'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'mision_vision_id'); ?>
		<?php echo $form->dropDownList($model, 'mision_vision_id', GxHtml::listDataEx(MisionesVisiones::model()->findAllAttributes(null,true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
