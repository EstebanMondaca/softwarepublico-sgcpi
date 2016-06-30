<div class="form" id="content">
<?php 
Yii::app()->clientScript->registerCoreScript('yiiactiveform'); 
$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'cierres-internos-form',
	'enableClientValidation'=>false,
	'clientOptions'=>array('validateOnSubmit'=>TRUE),
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
	<?php 
        if(isset($nombreEtapa)) echo "<h3>Vista Cierre Interno ".$nombreEtapa."</h3>";
    ?>
	<p class="note">
	</p>

	<div id="avances-form_es_" class="errorSummary" style="display:none">
		<p>Por favor corrija los siguientes errores de ingreso:</p>
		<ul>
			<li>dummy</li>
		</ul>
	</div>
		<div class="row">
		<?php 
			//hiddenField - textField
			echo $form->hiddenField($model, 'id_etapa', array ('value'=>''.$id_etapa)); 
			
			echo $form->hiddenField($model, 'id_usuario', array ('value'=>''.Yii::app()->user->id)); 

			echo $form->hiddenField($model, 'id_planificacion', array('value'=>''.$idPlanificaciones));
			
		?>
		</div><!-- row -->
		<div class="row">
			<?php echo $form->labelEx($model,'observaciones'); ?>
			<?php echo $form->textArea($model, 'observaciones',array('rows'=>3, 'cols'=>90,'readonly'=>'readonly')); ?>
			<?php echo $form->error($model,'observaciones'); ?>
		</div><!-- row -->
		<div class="row">
			<label for="CierresInternos_archivo">Acta de aprobacion de Definiciones Estratégicas: </label>
			<a href="<?php echo Yii::app()->baseUrl.'/upload/doc/'.$model->archivo ?>"><?php echo $model->archivo; ?></a>
		</div><!-- row -->
<?php
$this->endWidget();

?>
</div><!-- form -->
		