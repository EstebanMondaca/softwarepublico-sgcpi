<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<div class="form" >
<?php if(isset($titulo)) echo "<h3>".$titulo."</h3>"; ?>
<br>
<div style='float:left; width: 50%;'> Producto Estrategico :  <b>  <?php echo $nombreProductoEstrategico; ?> </b></div>
<div>Subproducto :  <b> <?php echo $nombreSubproducto; ?> </b></div>
<div>Producto Especifico : <b> <?php echo $producto_especificoN; ?></b></div>


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'indicadores-form',
	'enableAjaxValidation' => true,
));
//Identificador de usuario
$userID = Yii::app()->user->id;
//print_r(User::model()->findAll());

 $periodoActual = Yii::app()->session['idPeriodoSelecionado'];
?>
<p id='reportarerror' style='color: red;'></p>



<!--
Producto Seleccionado.

$userID = Yii::app()->user->id;
$name=Yii::app()->user->name;

-->
	
	
	
	<p class="note">
		
	</p>

	<?php echo $form->errorSummary($model); ?>
		<div class="row">
			<div style='width: 183px;float:left;'><?php echo $form->labelEx($model,'nombre'); ?></div>
			<b><?php echo $model->nombre; ?></b>
			<?php echo $form->error($model,'nombre'); ?>
		</div><!-- row -->
		<div class="row">
			<div style='width: 183px;float:left;'><?php echo $form->labelEx($model,'descripcion'); ?></div>
			<b><?php echo $model->descripcion; ?></b>
			<?php echo $form->error($model,'descripcion');// $model->responsable_id='3';?>
		</div><!-- row -->
		
		<div class="fieldset2">
			<div class="legend">Asignación Responsabilidad Interna</div>
			<div class="content"> 
				<div class="row">
					<div style='float:left;width: 33%;'>Centro de Responsabilidad : <b> <?php echo $centroResponsabilidad;?></b></div>
					<div style='float:left;width: 43%;'>Responsable : 
					
					<?php 
						//Validamos si es admiistrador
						if(Yii::app()->user->checkAccess("admin")){
						 echo $form->dropDownList(
						 	$model, 'responsable_id', 
						 	GxHtml::listDataEx(
						 		User::model()->findAll(array('order'=>'ape_paterno ASC','condition'=>'status=1 AND estado=1')),'id','nombrecompleto'
						 	)
						 	);

						}
					 	else{
					 			//Asignamos el identificador del usuario logueado al "responsable_id"
					 			echo $form->hiddenField($model, 'responsable_id',array('value'=>''.$userID));
					 			//Mostramos el nombre completo
					 			echo '<b>'.$usuarioActivoConcatenado.'</b>';
					 	}
					 	 
					 		
					?>
					
					
					</div>
					<div>CC : <b><?php echo $centroCosto;?></b></div>
				</div>
			
			</div>
		</div>
		<div style='display: inline-block;'>	
			<div class="fieldset2" style='float:left;'>
				<div class="legend">Clasificación </div>
				<div class="content"> 
					<div class="row">
						<?php echo $form->labelEx($model,'asociacion_id').':  '; ?>
						<?php //echo $form->dropDownList($model, 'asociacion_id', GxHtml::listDataEx(Asociaciones::model()->findAllAttributes(null, true))); ?>
						<b><?php  $asoc= Asociaciones::model()->find(array('condition'=>'id='.$model->asociacion_id) ); echo $asoc->nombre;?></b>
						
						<?php echo $form->error($model,'asociacion_id'); ?>
					</div><!-- row -->
					
					<div class="row">
						<?php echo $form->labelEx($model,'Desagregado por Sexo: '); ?></td>
						<b>
						<?php  
							     if ($nombreProductoEstrategico->tipo_producto_id=='1'){
                            		if ($nombreProductoEstrategico->desagregado_sexo=='1'){ echo "Si";}else{ echo "No";}
                            	}else { echo "No";}  
						?>
						</b>
						
					</div><!-- row -->
					<div class="row">
						<?php echo $form->labelEx($model,'Gestion Territorial:'); ?>
						<b>
						<?php  
								if ($nombreProductoEstrategico->tipo_producto_id=='1'){
                            		if ($nombreProductoEstrategico->gestion_territorial=='1'){ echo "Si";}else{echo "No";}
                    			}else {echo "No";}
                    	?>
						</b>
						
					</div><!-- row -->									
					<div class="row">
						<?php echo $form->labelEx($model,'clasificacion_ambito_id').' : '; ?>
						<?php //echo $form->dropDownList($model, 'clasificacion_ambito_id', GxHtml::listDataEx(ClasificacionesAmbitos::model()->findAllAttributes(null, true))); ?>
						<b><?php echo $model->clasificacionAmbito; ?></b>
						<?php echo $form->error($model,'clasificacion_ambito_id'); ?>
					</div><!-- row -->
					<div class="row">
						<?php echo $form->labelEx($model,'clasificacion_dimension_id').' : '; ?>
						<?php //echo $form->dropDownList($model, 'clasificacion_dimension_id', GxHtml::listDataEx(ClasificacionesDimensiones::model()->findAllAttributes(null, true))); ?>
						<b><?php echo $model->clasificacionDimension;?></b>
						<?php echo $form->error($model,'clasificacion_dimension_id'); ?>
					</div><!-- row -->
					<div class="row">
						<?php echo $form->labelEx($model,'clasificacion_tipo_id').' : '; ?>
						<?php //echo $form->dropDownList($model, 'clasificacion_tipo_id', GxHtml::listDataEx(ClasificacionesTipos::model()->findAllAttributes(null, true))); ?>
						<b><?php echo $model->clasificacionTipo;?></b>
						<?php echo $form->error($model,'clasificacion_tipo_id'); ?>
					</div><!-- row -->
									</div>
			</div>	
			<div class="fieldset2" style='float:left;margin-left: 10px;'>
				<div class="legend">Fórmula </div>
				<div class="content">
					<div class="row">
						<?php echo $form->labelEx($model,'unidad_id').' : '; ?>
						<?php //echo $form->dropDownList($model, 'unidad_id', array(''=>'---')+GxHtml::listDataEx(Unidades::model()->findAllAttributes(null, true))); ?>
						<b><?php echo $model->unidad;?></b>
						<?php echo $form->error($model,'unidad_id'); ?>
					</div><!-- row -->
					<div class="row"  >
						<?php echo $form->labelEx($model,'ascendente').': '; ?>
						<?php //echo $form->radioButtonList($model, 'ascendente',array('1'=> 'Si','0' =>'No' ),array('separator'=>'&nbsp;&nbsp;&nbsp;')); ?>
						<?php  $keyascendente = array_search($model->ascendente, array('Si'=> '1','No' =>'0' )); echo $keyascendente;  ?>
						<?php echo $form->error($model,'ascendente'); ?>
					</div><!-- row -->
					<div class="row">
						<?php echo $form->labelEx($model,'tipo_formula_id').' : '; ?>
						<?php //echo $form->dropDownList($model, 'tipo_formula_id', array(''=>'---')+GxHtml::listDataEx(TiposFormulas::model()->findAllAttributes(null, true))); ?>
						<b><?php echo $model->tipoFormula;?></b>
						<?php echo $form->error($model,'tipo_formula_id'); ?>
						 <div id="formula_para_calculo" style="display:none"></div>
					</div><!-- row -->	
					<div class="row">
						<?php echo $form->labelEx($model,'conceptoa'); ?>
						<?php echo $form->textField($model, 'conceptoa', array('readonly'=>'readonly')); ?>
						<?php echo $form->error($model,'conceptoa'); ?>
					</div><!-- row -->
					<div class="row">
						<?php echo $form->labelEx($model,'conceptob'); ?>
						<?php echo $form->textField($model, 'conceptob', array('readonly'=>'readonly')); ?>
						<?php echo $form->error($model,'conceptob'); ?>
					</div><!-- row -->
					<div class="row">
						<?php echo $form->labelEx($model,'conceptoc'); ?>
						<?php echo $form->textField($model, 'conceptoc', array('readonly'=>'readonly')); ?>
						<?php echo $form->error($model,'conceptoc'); ?>
					</div><!-- row -->									
				</div>
			</div>	
		</div>	
		
		<div class="fieldset2">
			<div class="legend">Descripción Fórmula y Medios de Verificación</div>
			<div class="content"> 
				<div class="row">
					<div style='width: 150px;float:left;'> <?php echo $form->labelEx($model,'formula'); ?></div>
					<?php echo $form->textArea($model, 'formula', array('rows'=>2, 'cols'=>70,'readonly'=>'readonly')); ?>
					<?php echo $form->error($model,'formula'); ?>
				</div><!-- row -->
				<div class="row">
					<div style='width: 150px;float:left;'><?php echo $form->labelEx($model,'medio_verificacion'); ?></div>
					<?php echo $form->textArea($model, 'medio_verificacion', array('rows'=>2, 'cols'=>70,'readonly'=>'readonly')); ?>
					<?php echo $form->error($model,'medio_verificacion'); ?>
				</div><!-- row -->
				<div class="row">
					<div style='width: 150px;float:left;'><?php echo $form->labelEx($model,'notas'); ?></div>
					<?php echo $form->textArea($model, 'notas', array('rows'=>2, 'cols'=>70,'readonly'=>'readonly')); ?>
					<?php echo $form->error($model,'notas'); ?>
				</div><!-- row -->
			</div>
		</div>	
		
		<div style='display: inline-block;'>	
			<div class="fieldset2" style='float:left;'>
				<div class="legend">Resultados Históricos del Indicador </div>
				<div class="content">  
					<div class="row">
					<?php echo $form->labelEx($model,'efectivot3'); $t3 = $periodoActual-3; echo ' ('.$t3.')'; ?>
					<?php echo $form->textField($model, 'efectivot3', array('maxlength' => 200,'readonly'=>'readonly')); ?>
					<?php echo $form->error($model,'efectivot3'); ?>
					</div><!-- row -->
					<div class="row">
					<?php echo $form->labelEx($model,'efectivot2'); $t2 = $periodoActual-2; echo ' ('.$t2.')'; ?>
					<?php echo $form->textField($model, 'efectivot2', array('maxlength' => 200,'readonly'=>'readonly')); ?>
					<?php echo $form->error($model,'efectivot2'); ?>
					</div><!-- row -->
					<div class="row">
					<?php echo $form->labelEx($model,'efectivot1'); $t1 = $periodoActual-1; echo ' ('.$t1.')';?>
					<?php echo $form->textField($model, 'efectivot1', array('maxlength' => 200,'readonly'=>'readonly')); ?>
					<?php echo $form->error($model,'efectivot1'); ?>
					</div><!-- row -->
		
				</div>
			</div>	
			<div class="fieldset2" style='float:left;margin-left: 10px;'>
				<div class="legend">Metas año t (<?php echo $periodoActual ?>) </div>
				<div class="content">  
					<div class="row">
						<?php echo $form->labelEx($model,'meta_anual'); ?>
						<?php echo $form->textField($model, 'meta_anual', array('maxlength' => 200,'readonly'=>'readonly')); ?>
						<?php echo $form->error($model,'meta_anual'); ?>
					</div><!-- row -->
					<div class="row">
						
						<?php echo $form->labelEx($model,'frecuencia_control_id'); ?>
						<?php 
						if($buttons=='create'){					
							echo $form->dropDownList($model, 'frecuencia_control_id', GxHtml::listDataEx(FrecuenciasControles::model()->findAll(array('condition'=>'estado=1'))),array('id'=>'frecuenciaControl', 'onchange'=>'js:metasParcialesInput(this.value);')); 
						}else{
							
							$frecuencia = $model->frecuenciaControl;
							echo $form->hiddenField($model, 'frecuencia_control_id');
					 		echo ": <b>".$frecuencia."</b>";
						}
						?>
						<?php echo $form->error($model,'frecuencia_control_id'); ?>
					</div><!-- row -->
					
					<div class="row">
						<div style='float:left;'>
							Metas Parciales &nbsp;&nbsp;&nbsp;
						</div>
						<div style='width:490px'>
							<div class='indicadores_meses'>Ene
								<div class='indicadorMesInactivo' >
									<input name="Indicadores[enero]" class="meses" type="hidden" id="enero"  readonly="readonly" >
								</div>
							</div>
							<div class='indicadores_meses'>Feb
								<div class='indicadorMesInactivo' >
								<input  name="Indicadores[febrero]"  class="meses" type="hidden" id="febrero"  readonly="readonly">
								</div>
							</div>
							<div class='indicadores_meses'>Mar
								<div class='indicadorMesInactivo' >
								<input name="Indicadores[marzo]" class="meses" type="hidden" id="marzo"  readonly="readonly">
								</div>
							</div>
							<div class='indicadores_meses'>Abr
								<div class='indicadorMesInactivo' >
								<input  name="Indicadores[abril]"  class="meses"type="hidden" id="abril"  readonly="readonly">
								</div>
							</div>
							<div class='indicadores_meses'>May
								<div class='indicadorMesInactivo' >
								<input  name="Indicadores[mayo]" class="meses"type="hidden" id="mayo"  readonly="readonly">
								</div>
							</div>
							<div class='indicadores_meses'>Jun
								<div class='indicadorMesInactivo' >
								<input  name="Indicadores[junio]" class="meses"type="hidden" id="junio"  readonly="readonly">
								</div>
							</div>
							<div class='indicadores_meses'>Jul
								<div class='indicadorMesInactivo' >
								<input  name="Indicadores[julio]" class="meses"type="hidden" id="julio"  readonly="readonly">
								</div>
							</div>
							<div class='indicadores_meses'>Ago
								<div class='indicadorMesInactivo' >
								<input name="Indicadores[agosto]"  class="meses"type="hidden" id="agosto"  readonly="readonly">
								</div>
							</div>
							<div class='indicadores_meses'>Sep
								<div class='indicadorMesInactivo'>
								<input  name="Indicadores[septiembre]" class="meses"type="hidden"  id="septiembre"  readonly="readonly">
								</div>
							</div>
							<div class='indicadores_meses'>Oct
								<div class='indicadorMesInactivo' >
								<input  name="Indicadores[octubre]" class="meses"type="hidden" id="octubre"  readonly="readonly">
								</div>
							</div>
							<div class='indicadores_meses'>Nov
								<div class='indicadorMesInactivo' >
								<input name="Indicadores[noviembre]"  class="meses" type="hidden" id="noviembre"  readonly="readonly">
								</div>
							</div>
							<div class='indicadores_meses'>Dic
								<div class='indicadorMesInactivo' >
								<input  name="Indicadores[diciembre]" class="meses" type="hidden" id="diciembre" readonly="readonly" >
								</div>
							</div>
						</div>
						<?php 
						$form->hiddenField($model, 'meta_parcial');
						//echo $form->textField($model, 'meta_parcial', array('maxlength' => 200)); ?>
						<?php //echo $form->error($model,'meta_parcial'); ?>
					</div><!-- row -->				
				</div>
			</div>	
		</div>		
		
		<div class="fieldset2">
			<div class="legend">Supuestos</div>
			<div class="content">  
				<div class="row">
				<div style='width: 150px;float:left;'><?php echo $form->labelEx($model,'supuestos'); ?></div>
				<?php echo $form->textArea($model, 'supuestos',array('rows'=>2, 'cols'=>70,'readonly'=>'readonly')); ?>
				<?php echo $form->error($model,'supuestos'); ?>
				</div><!-- row -->
			</div>
		</div>	
		
<!-- ######################################## -->


		

		<label><?php //echo GxHtml::encode($model->getRelationLabel('actividades')); ?></label>
		<?php //echo $form->checkBoxList($model, 'actividades', GxHtml::encodeEx(GxHtml::listDataEx(Actividades::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php //echo GxHtml::encode($model->getRelationLabel('tiposIndicadores')); ?></label>
		<?php echo $form->checkBoxList($model, 'tiposIndicadores', GxHtml::encodeEx(GxHtml::listDataEx(TiposIndicadores::model()->findAll(array('condition'=>'estado=1'))), false, true)); ?>

<?php
if($buttons=='update'){	
	echo '<script type="text/javascript">metasParcialesInput("'.$frecuencia.'");</script>';
	foreach($hitosIndicadores as $row){
		//echo '<script type="text/javascript"> document.getElementById("'.$row->mes.'").value = "'.row->meta_parcial.'" </script>';
		echo '<script type="text/javascript"> document.getElementById("'.$row->mes.'").value = "'.$row->meta_parcial.'" </script>';

	}
	
	
	
	
	
}

$this->endWidget();
?>

</div>

