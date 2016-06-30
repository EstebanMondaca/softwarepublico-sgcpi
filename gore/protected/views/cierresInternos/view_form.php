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
		
		
		<?php  
			// consultamos si tiene  permisos de administrador
			//$admin=Yii::app()->user->checkAccessChange(array('modelName'=>'CierresInternos','fieldName'=>'id_usuario','idRow'=>Yii::app()->user->id));
			//echo $admin; 
			//if(CierresInternosController::validateAccess()){ 
			//if($admin){ 
			?>
			
				<div class="row">
					<?php echo $form->labelEx($model,'observaciones'); ?>
					<?php echo $form->textArea($model, 'observaciones',array('rows'=>3, 'cols'=>90)); ?>
					<?php echo $form->error($model,'observaciones'); ?>
					<div id="CierresInternos_observaciones_em_" class="errorMessage" style="display:none"></div>
				</div><!-- row -->
				
				<div class="row" style="display: none;"  id="uploadPDF">
					<label for="CierresInternos_archivo">Acta de aprobacion de Definiciones Estratégicas: </label>
					<?php  
						echo $form->fileField($model, 'documento');
						echo $form->error($model, 'documento');
					?>  
					<div id="CierresInternos_documento_em_" class="errorMessage" style="display:none"></div>
					<div class="hint">Puede cargar solo un documento PDF. </div>
				</div>	
				
				<?php if(empty($model->archivo))
				{
					echo "<script language=\"JavaScript\">mostrarUploadPDF();</script>";
				}else{ 
				?>
				<div class="row" id="urlPDF">
					<label for="CierresInternos_archivo">Acta de aprobacion de Definiciones Estratégicas: </label>
					<a target='_blank' href="<?php echo Yii::app()->request->baseUrl.'/upload/doc/'.$model->archivo ?>"><?php echo $model->archivo; ?></a>
					<a class="delete" href="#" onclick="borrarArchivo('<?php echo $model->id;?>');" title="Eliminar"> <img alt="Eliminar" src="/gore/images/delete.png"> </a>
				</div><!-- row -->
				<?php 	
				 }
				?>
				
					<div class="row buttons">        
        	<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?>
        	        
   		 </div>
		<?php 	//}else{ ?>
		<!-- 
		<div class="row">
			<?php //echo $form->labelEx($model,'observaciones'); ?>
			<?php //echo $form->textArea($model, 'observaciones',array('rows'=>3, 'cols'=>90,'readonly'=>'readonly')); ?>
			<?php //echo $form->error($model,'observaciones'); ?>
		</div><!-- row --
		<div class="row">
			<label for="CierresInternos_archivo">Acta de aprobacion de Definiciones Estratégicas: </label>
			<a href="<?php //echo Yii::app()->baseUrl.'/upload/doc/'.$model->archivo ?>"><?php //echo $model->archivo; ?></a>
		</div><!-- row --
		 -->
		<?php //} ?>

<?php
$this->endWidget();

?>
</div><!-- form -->
<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
jQuery('a[rel="tooltip"]').tooltip();
jQuery('a[rel="popover"]').popover();
$('#cierres-internos-form').yiiactiveform({'validateOnSubmit':true,'attributes':[
{'id':'CierresInternos_observaciones','inputID':'CierresInternos_observaciones','errorID':'CierresInternos_observaciones_em_','model':'CierresInternos','name':'observaciones','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {
	if($.trim(value)=='') {
		messages.push("Observaciones no puede ser nulo.");
	}
}},
{'id':'CierresInternos_documento','inputID':'CierresInternos_documento','errorID':'CierresInternos_documento_em_','model':'CierresInternos','name':'documento','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) {
	var cadena = $.trim(value);
	var ext = cadena.split('.').pop().toLowerCase();
	if($.trim(value)!='') {
		if($.inArray(ext, ['pdf']) == -1) {
			messages.push("Archivo	Acta de aprobacion de Definiciones Estratégicas: Acepta solo archivos PDF");
		}
		
	}

	}
	}
],'summaryID':'cierres-internos-form_es_'});
});
/*]]>*/
</script>

