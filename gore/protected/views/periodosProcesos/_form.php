<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'periodos-procesos-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model, 'descripcion', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('planificaciones')); ?></label>
		<?php echo $form->checkBoxList($model, 'planificaciones', GxHtml::encodeEx(GxHtml::listDataEx(Planificaciones::model()->findAll(array('condition'=>'estado=1'))), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->