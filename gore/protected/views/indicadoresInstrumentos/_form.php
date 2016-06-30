<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'indicadores-instrumentos-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'id_indicador'); ?>
		<?php echo $form->dropDownList($model, 'id_indicador', GxHtml::listDataEx(Indicadores::model()->findAll(array('condition'=>'estado=1')))); ?>
		<?php echo $form->error($model,'id_indicador'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'id_instrumento'); ?>
		<?php echo $form->dropDownList($model, 'id_instrumento', GxHtml::listDataEx(Instrumentos::model()->findAll(array('condition'=>'estado=1')))); ?>
		<?php echo $form->error($model,'id_instrumento'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ponderacion'); ?>
		<?php echo $form->textField($model, 'ponderacion'); ?>
		<?php echo $form->error($model,'ponderacion'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model, 'estado'); ?>
		<?php echo $form->error($model,'estado'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->