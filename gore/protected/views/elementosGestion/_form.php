<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'elementos-gestion-form',
	'enableAjaxValidation' => false,
));
?>
	<?php 
	if(isset($titulo)) echo "<h3>".$titulo."</h3>";
	?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>
	
	<?php 
	$subCriterios = Subcriterios::model()->findAll(array('condition'=>'id='.$_GET['idSubcriterio'].' AND estado = 1'));
	?>
	
	<?php echo $form->errorSummary($model); ?>
		<table width="100%">
		<tr>
		  <td>
		    <?php echo $form->labelEx($model,'Criterio'); ?>:
		    <?php //echo $form->dropDownList($model, 'id_subcriterio', GxHtml::listDataEx(Criterios::model()->findAll(array('condition'=>'id='.$subCriterios[0]->id_criterio)))); ?>
		  </td>
		  <td><?php echo (isset($subCriterios[0]))?$subCriterios[0]->idCriterio:"";?></td>
		 </tr>
		 <tr>
		<td>      
		<?php echo $form->labelEx($model,'id_subcriterio'); ?>:
		<?php //echo $form->dropDownList($model, 'id_subcriterio', GxHtml::listDataEx(Subcriterios::model()->findAll(array('condition'=>'id='.$_GET['idSubcriterio'])))); ?>
		</td>
		<td><?php echo (isset($subCriterios[0]))?$subCriterios[0]:"";?></td>
		
		</tr>
		<tr>
		
		<td><?php echo $form->labelEx($model,'n_elementogestion',array('class'=>'blockLabel')); ?></td>
		<td><?php echo $form->textField($model, 'n_elementogestion', array('size'=>1, 'maxlength' => 2)); ?>
		    <?php echo $form->error($model,'n_elementogestion'); ?></td>
		
		</tr>
		<tr>
		
		<td><?php echo $form->labelEx($model,'nombre',array('class'=>'blockLabel')); ?></td>
		<td><?php echo $form->textField($model, 'nombre', array('size'=>87, 'maxlength' => 200)); ?>
		    <?php echo $form->error($model,'nombre'); ?></td>
		
		</tr>
		<tr>
		
		<td></td>
		<td><div class="row buttons"><?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?></div></td>
		
		</tr>		
		</table>
		
<?php
//echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->