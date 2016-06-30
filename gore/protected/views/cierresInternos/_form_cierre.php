<div class="form">


<?php 
	Yii::app()->clientScript->registerCoreScript('yiiactiveform'); 
	//Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/form.js'); 
    
	$form = $this->beginWidget('GxActiveForm', array(
		'id' => 'cierres-internos-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array('validateOnSubmit'=>TRUE),
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	));

?>
	<?php 
        if(isset($nombreEtapa)) echo "<h3>Cierre Interno ".$nombreEtapa."</h3>";
    ?>
	
	
	<p class="note">
	
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php 
			//hiddenField - textField
			echo $form->hiddenField($model, 'id_etapa', array ('value'=>''.$id_etapa)); 
			
			echo $form->hiddenField($model, 'id_usuario', array ('value'=>''.Yii::app()->user->id)); 

			echo $form->hiddenField($model, 'id_planificacion', array('value'=>''.$idPlanificaciones));
			
		?>
		<?php echo $form->error($model,'id_etapa'); ?>
		</div><!-- row -->
		
		<div class="row">
		<?php echo $form->labelEx($model,'observaciones'); ?>
		<?php echo $form->textArea($model, 'observaciones',array('rows'=>3, 'cols'=>90)); ?>
		<?php echo $form->error($model,'observaciones'); ?>
		</div><!-- row -->
		
				
		<div class="row">
			<?php echo $form->labelEx($model,'archivo'); ?>
			<label for="CierresInternos_archivo">Acta de aprobacion de Definiciones Estratégicas: </label>
			<?php  
				//echo $form->labelEx($model, 'documento');
				echo $form->fileField($model, 'documento');
				echo $form->error($model, 'documento');
			?>  
			<div class="hint">Puede cargar solo un documento PDF. </div>
		</div>
		
			<?php
				echo GxHtml::submitButton(Yii::t('app', 'Save'));
				$this->endWidget();
			?>

		<div class="limpia"></div>
		

<div class="limpia"></div>
</div><!-- form -->

