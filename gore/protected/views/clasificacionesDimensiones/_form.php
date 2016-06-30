<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'clasificaciones-dimensiones-form',
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
		<table>
		<tr>
		<div class="row">
		<td><?php echo $form->labelEx($model,'nombre',array('class'=>'blockLabel')); ?></td>
		<td><?php echo $form->textField($model, 'nombre', array('size'=>100, 'maxlength' => 200)); ?></td>
		<td><?php echo $form->error($model,'nombre'); ?></td>
		</div><!-- row -->
		</tr>
		<tr>
		<div class="row buttons">
		<td></td>
		<td><?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?></td>
		<td></td>
		</div>
		</tr>
		</table>
	
<?php
//echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->