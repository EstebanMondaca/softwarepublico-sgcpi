<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'viaticos-form',
	'enableAjaxValidation'=>true,
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
		<div class="row" >
		
		
		<td><?php echo $form->labelEx($model,'grado_desde',array('class'=>'blockLabel')); ?></td>
		
		<td>
		<table>
		<tr>
		<td><?php echo $form->textField($model, 'grado_desde', array('size'=>40,'maxlength' => 10)); ?></td>
		<td><?php echo $form->error($model,'grado_desde'); ?></td>
		
		<td><?php echo $form->labelEx($model,'grado_hasta',array('class'=>'blockLabel')); ?></td>
		<td><?php echo $form->textField($model, 'grado_hasta', array('size'=>40,'maxlength' => 10)); ?></td>
		</tr>
		</table>
		</td>
		
		<td><?php echo $form->error($model,'grado_hasta'); ?></td>
		</div><!-- row -->
		</tr>
		
		<tr>
		<div class="row">
		<td><?php echo $form->labelEx($model,'monto_100'); ?></td>
		<td><?php echo $form->textField($model, 'monto_100', array('size'=>96,'maxlength' => 10)); ?></td>
		<td><?php echo $form->error($model,'monto_100'); ?></td>
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