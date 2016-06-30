<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'tipos-clientes-form',
	'enableAjaxValidation' => false,
));
?>
	<?php 
	if(isset($titulo)) echo "<h3>".$titulo."</h3>";
	?>
		
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model, 'nombre', array('size'=>100, 'maxlength' => 200)); ?>
		<?php echo $form->error($model,'nombre'); ?>
		</div><!-- row -->
	
	<div class="row buttons">        
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?>      
	</div>	
		
<?php
//echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->