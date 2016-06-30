<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'subcriterios-form',
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
		
		<table width="100%">
		<tr>
		<td><?php echo $form->labelEx($model,'id_criterio',array('class'=>'blockLabel')); ?></td>
		<td><?php echo $form->dropDownList($model, 'id_criterio', GxHtml::listDataEx(Criterios::model()->findAll(array('condition'=>'id='.$_GET['idCriterio'])))); ?>
		    <?php echo $form->error($model,'id_criterio'); ?></td>
		
		</tr>		
		<tr>
		<td><?php echo $form->labelEx($model,'n_subcriterio',array('class'=>'blockLabel')); ?></td>
		<td><?php echo $form->textField($model, 'n_subcriterio', array('size'=>1,'maxlength' => 2)); ?>
		    <?php echo $form->error($model,'n_subcriterio'); ?></td>
		
		</tr>
		<tr>		
		
		<td><?php echo $form->labelEx($model,'nombre',array('class'=>'blockLabel')); ?></td>
		<td><?php echo $form->textField($model, 'nombre', array('size'=>100, 'maxlength' => 100)); ?>
		    <?php echo $form->error($model,'nombre'); ?></td>
		
		</tr>
		<tr>
		<td><?php echo $form->labelEx($model,'cantidad_elementos',array('class'=>'blockLabel')); ?></td>
		<td>
    		<table class="row" width="100%">
        		<tr>
        		  <td><?php echo $form->textField($model, 'cantidad_elementos', array('size'=>2,'maxlength' => 3)); ?>
        		      <?php echo $form->error($model,'cantidad_elementos'); ?></td>
        		      <td></td>
        		
            		<td align="right"><?php echo $form->labelEx($model,'factor',array('class'=>'blockLabel')); ?></td>
            		<td><?php echo $form->textField($model, 'factor', array('size'=>2,'maxlength' => 10)); ?>
            		    <?php echo $form->error($model,'factor'); ?></td>
        		
            		<td align="right"><?php echo $form->labelEx($model,'puntaje_elemento',array('class'=>'blockLabel')); ?></td>
            		<td><?php echo $form->textField($model, 'puntaje_elemento', array('size'=>2,'maxlength' => 5)); ?>
            		    <?php echo $form->error($model,'puntaje_elemento'); ?></td>
            		
        		</tr>
    		</table>
		</td>
		</tr>
		<tr>
		 
		<td></td>  
        <td><div class="row buttons"> <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?></div> </td>
 	    
 	    </tr>
		</table>
		
		

<?php
$this->endWidget();
?>
</div><!-- form -->