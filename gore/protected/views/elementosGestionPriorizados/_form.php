<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'elementos-gestion-priorizados-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'id_elemento_gestion'); ?>
		<?php echo $form->dropDownList($model, 'id_elemento_gestion', GxHtml::listDataEx(ElementosGestion::model()->findAll(array('condition'=>'estado=1')))); ?>
		<?php echo $form->error($model,'id_elemento_gestion'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'id_planificacion'); ?>
		<?php echo $form->dropDownList($model, 'id_planificacion', GxHtml::listDataEx(Planificaciones::model()->findAll(array('condition'=>'estado=1')))); ?>
		<?php echo $form->error($model,'id_planificacion'); ?>
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