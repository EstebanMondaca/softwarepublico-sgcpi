<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'planificaciones-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'estado_planificacion_id'); ?>
		<?php echo $form->dropDownList($model, 'estado_planificacion_id', GxHtml::listDataEx(EstadosPlanificaciones::model()->findAllAttributes(null,true))); ?>
		<?php echo $form->error($model,'estado_planificacion_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'periodo_proceso_id'); ?>
		<?php echo $form->dropDownList($model, 'periodo_proceso_id', GxHtml::listDataEx(PeriodosProcesos::model()->findAllAttributes(null,true))); ?>
		<?php echo $form->error($model,'periodo_proceso_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model, 'nombre', array('maxlength' => 200)); ?>
		<?php echo $form->error($model,'nombre'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model, 'descripcion'); ?>
		<?php echo $form->error($model,'descripcion'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'mision_vision_id'); ?>
		<?php echo $form->dropDownList($model, 'mision_vision_id', GxHtml::listDataEx(MisionesVisiones::model()->findAllAttributes(null,true))); ?>
		<?php echo $form->error($model,'mision_vision_id'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('desafiosEstrategicoses')); ?></label>
		<?php echo $form->checkBoxList($model, 'desafiosEstrategicoses', GxHtml::encodeEx(GxHtml::listDataEx(DesafiosEstrategicos::model()->findAll(array('condition'=>'estado=1'))), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->