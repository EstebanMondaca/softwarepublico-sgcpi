<div class="form">


<?php 
Yii::app()->clientScript->registerCoreScript('yiiactiveform'); 
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
</div><!-- form -->
<script type="text/javascript">
/*<![CDATA[
jQuery(function($) {
jQuery('a[rel="tooltip"]').tooltip();
jQuery('a[rel="popover"]').popover();
$('#cierres-internos-form').yiiactiveform({'validateOnSubmit':true,'attributes':[
	{
		'id':'CierresInternos_documento','inputID':'CierresInternos_documento','errorID':'CierresInternos_documento_em_','model':'CierresInternos','name':'documento','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute)
		{
			if($.trim(value)!='') {
				if($.inArray(ext, ['pdf']) == -1) {
					messages.push("Archivo	Acta de aprobacion de Definiciones Estratégicas: Acepta solo archivos PDF");
				}
				
			}
		}
	},
	 {'id':'CierresInternos_id_etapa','inputID':'CierresInternos_id_etapa','errorID':'CierresInternos_id_etapa_em_','model':'CierresInternos','name':'id_etapa','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {
		 if($.trim(value)!='') {
		 if(!value.match(/^\s*[+-]?\d+\s*$/)) {
		 messages.push("Etapas debe ser entero.");
		 }
		 }
		 }
	 },
	 {'id':'CierresInternos_observaciones','inputID':'CierresInternos_observaciones','errorID':'CierresInternos_observaciones_em_','model':'CierresInternos','name':'observaciones','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {
		 if($.trim(value)=='') {
		 messages.push("Observaciones no puede ser nulo.");
		 }
	 	}
	 }
	],'summaryID':'cierres-internos-form_es_'});
});
]]>*/
  
</script>
