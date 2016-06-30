<?php Yii::app()->clientScript->registerCoreScript('jquery'); 


Yii::app()->clientScript->registerScript('habilitar', "
   
    //cambiando alto del iframe en caso de estar solicitando esta vista desde lineas de acción
    parent.$('#iframeModal').height($('html').height());
	
    modificarUnidad($('#Indicadores_tipo_formula_id').val());    

    ");



			 	
?>

<div class="form">
<?php if(isset($titulo)) echo "<h3>".$titulo."</h3>"; ?>
<br>
<?php
    //En caso de no ser un indicador de linea de acción
    if($producto_especificoN!=""){
?>
<div> Producto Estratégico :  <b>  <?php echo $nombreProductoEstrategico; ?> </b></div>
<div>Subproducto :  <b> <?php echo $nombreSubproducto; ?> </b></div>
<div>Producto Específico : <b> <?php echo $producto_especificoN; ?></b></div>

<?php }else{
     if(!$model->isNewRecord){
         echo "<div>Producto Estratégico:  <b>".$nombreProductoEstrategico."</b></div>";
         if($model->lineasAccions)
            echo "<div>AMI o LA:  <b>".$model->lineasAccions[0]->nombre."</b></div>";         
     }
        
    
}?>

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'indicadores-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>TRUE),
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
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>
<?php
//cargamos el producto especifico
            if(isset($model->producto_especifico_id)){
                echo $form->hiddenField($model, 'producto_especifico_id');
            }else{
                //if($producto_especificoID!=""){                
                    echo $form->hiddenField($model, 'producto_especifico_id',array('value'=>''.$producto_especificoID));
                //}
            }

?>
	<?php echo $form->errorSummary($model); ?>
		<div class="row">
			<div style='width: 183px;float:left;'><?php echo $form->labelEx($model,'nombre'); ?></div>
			<?php echo $form->textField($model, 'nombre', array('size'=>60,'maxlength' => 200)); ?>
			<?php echo $form->error($model,'nombre'); ?>
		</div><!-- row -->
		<div class="row">
			<div style='width: 183px;float:left;'><?php echo $form->labelEx($model,'descripcion'); ?></div>
			<?php echo $form->textArea($model, 'descripcion', array('rows'=>2, 'style'=>'width: 384px;')); ?>
			<?php echo $form->error($model,'descripcion');// $model->responsable_id='3';?>
		</div><!-- row -->
		<div class="fieldset2">
			<div class="legend">Asignación Responsabilidad Interna</div>
			<div class="content"> 
				<div class="row">
					<div style='float:left;width: 33%;'><b>Centro de Responsabilidad : </b> <?php echo $centroResponsabilidad;?></div>
					<div style='float:left;width: 43%;'><b>Responsable : </b>
					<?php 
						//Validamos si es admiistrador
						//si viene con el nombre del producto especifico NO ES UN INDICADOR DE UNA AMI/LA
						if(Yii::app()->user->checkAccess("admin") && $producto_especificoN!=""){
							$criteria=new CDbCriteria;
							$criteria->join='INNER JOIN users_centros a ON id=a.user_id AND a.centro_id='.$centroCosto->id.' INNER JOIN AuthAssignment b on b.userid=user.id';
							$criteria->order='ape_paterno ASC';
                            $criteria->condition='user.status=1 AND user.estado=1 AND b.itemname="gestor"';
							$criteria->distinct=true;
							
						    echo $form->dropDownList($model, 'responsable_id', GxHtml::listDataEx(						 		
						 		User::model()->findAll($criteria),'id','nombrecompleto'
						 	)
						 	,array('options'=>array($userID=>array('selected'=>$userID)))
						 	);
						}
					 	else{
					 	    //viene desde una AMI/LA
					 	    if(Yii::app()->user->checkAccess("admin") && $producto_especificoN==""){                                
                                $existeEG=false;
                                if(!$model->isNewRecord){
                                    if(isset($model->lineasAccions[0])){
                                        foreach($model->lineasAccions[0]->laElemGestions as $v){                                            
                                            if($v->estado==1){
                                                $existeEG=true;
                                            }
                                        }
                                    }
                                }
                                if($existeEG){
                                    echo $form->hiddenField($model, 'responsable_id');
                                    //Obtenemos el nombre completo
                                    echo IndicadoresController::obtenerNombreUsuario($model->responsable_id);
                                    echo "<br/><label class='error'>* Si desea seleccionar un nuevo responsable del indicador, es necesario eliminar los Elementos de gestión asociados a la AMI/LA.</label>";
                                }else{
                                    $criteria=new CDbCriteria;
                                    $criteria->join='INNER JOIN users_centros a ON id=a.user_id AND a.centro_id='.$centroCosto->id.' INNER JOIN AuthAssignment b on b.userid=user.id';
                                    $criteria->order='ape_paterno ASC';
                                    $criteria->condition='user.status=1 AND user.estado=1 AND b.itemname="gestor"';
                                    $criteria->distinct=true;
                                    
                                    echo $form->dropDownList($model, 'responsable_id', GxHtml::listDataEx(                              
                                        User::model()->findAll($criteria),'id','nombrecompleto'
                                    )
                                    ,array('options'=>array($userID=>array('selected'=>$userID)))
                                    );
                                }
                            }else{
                                //Cuando el responsable está vacio indica que es un nuevo registro
                                if(isset($model->responsable_id)){
                                    echo $form->hiddenField($model, 'responsable_id');
                                    //Obtenemos el nombre completo
                                    echo IndicadoresController::obtenerNombreUsuario($model->responsable_id);
                                }else{
                                    //Asignamos el identificador del usuario logueado al "responsable_id"
                                    echo $form->hiddenField($model, 'responsable_id',array('value'=>''.$userID));
                                    //Mostramos el nombre completo
                                    echo $usuarioActivoConcatenado;
                                }
                            }					 		
					 	} 
					 		
					?>
					<?php echo $form->error($model,'responsable_id'); ?>
					
					</div>
					<?php if($centroCosto!=""){?>
					<div><b>CC : </b><?php echo $centroCosto;?></div>
					<?php }?>
				</div>
			
			</div>
		</div>
		<div style='display: inline-block;'>	
			<div class="fieldset2" style='float:left;width: 426px;height: 270px;'>
				<div class="legend">Clasificación </div>
				<table border="0" cellspacing="5" cellpadding="5" width="100%">
				    
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'asociacion_id'); ?></td>
                        <td><?php 
                            $asociaciones=array();
                            
                            if($producto_especificoN!=""){
                                if($nombreProductoEstrategico->tipo_producto_id==1){
                                    $asociaciones=array(3,4);
                                }else{
                                    $asociaciones=array(3,5);
                                }
                                
                            }else{
                                $asociaciones=array(1, 2);
                            }
                            echo $form->dropDownList($model, 'asociacion_id', array(''=>'---')+GxHtml::listDataEx(Asociaciones::model()->findAll(array('condition'=>'estado=1 AND id IN ('.implode(",", $asociaciones).')')))); 
                            
                         ?>
                        <?php echo $form->error($model,'asociacion_id'); ?></td>
                    </tr>
                    <?php 
                    //En caso de no ser un indicador de linea de acción
                    if($producto_especificoN!=""){
                    ?>
                         <tr>
                             <td align="right"><?php echo $form->labelEx($model,'Desagregado por Sexo: '); ?></td>
                            <td><?php 
                            	//echo $nombreProductoEstrategico->tipo_producto_id;
                            	//echo $nombreProductoEstrategico->gestion_territorial;
               	
                            	// 1 = Del Negocio ----- 2 = De apoyo
                            	if ($nombreProductoEstrategico->tipo_producto_id=='1'){
                            		if ($nombreProductoEstrategico->desagregado_sexo=='1'){ echo "Si";}else{ echo "No";}
                            	}else { echo "No";}
                            	?>
                           </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->labelEx($model,'Gestion Territorial:'); ?></td>
                            <td><?php 
                    			if ($nombreProductoEstrategico->tipo_producto_id=='1'){
                            		if ($nombreProductoEstrategico->gestion_territorial=='1'){ echo "Si";}else{echo "No";}
                    			}else {echo "No";}
                    }   ?>
                          </td>
                        </tr>
              
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'clasificacion_ambito_id'); ?></td>
                        <td><?php echo $form->dropDownList($model, 'clasificacion_ambito_id', array(''=>'---')+GxHtml::listDataEx(ClasificacionesAmbitos::model()->findAll(array('condition'=>'estado=1')))); ?>
                        <?php echo $form->error($model,'clasificacion_ambito_id'); ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'clasificacion_dimension_id'); ?></td>
                        <td><?php echo $form->dropDownList($model, 'clasificacion_dimension_id', array(''=>'---')+GxHtml::listDataEx(ClasificacionesDimensiones::model()->findAll(array('condition'=>'estado=1')))); ?>
                        <?php echo $form->error($model,'clasificacion_dimension_id'); ?></td>
                    </tr>
                    <tr>
                         <td align="right"><?php echo $form->labelEx($model,'clasificacion_tipo_id'); ?></td>
                        <td><?php echo $form->dropDownList($model, 'clasificacion_tipo_id', array(''=>'---')+GxHtml::listDataEx(ClasificacionesTipos::model()->findAll(array('condition'=>'estado=1')))); ?>
                        <?php echo $form->error($model,'clasificacion_tipo_id'); ?></td>
                    </tr>
                </table>
			</div>	
			<div class="fieldset2" style='float:left;margin-left: 10px;height: 270px;width: 426px;'>
				<div class="legend">Fórmula </div>
				<table border="0" cellspacing="5" cellpadding="5" width="100%">
				    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'ascendente'); ?>:</td>
                        <td>
                        <?php echo $form->radioButtonList($model, 'ascendente',array('1'=> 'Si','0' =>'No' ),array('separator'=>'&nbsp;&nbsp;&nbsp;')); ?>
                        <?php echo $form->error($model,'ascendente'); ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'tipo_formula_id'); ?></td>
                        <td>
                        <?php 
                        	echo $form->dropDownList($model, 'tipo_formula_id', array(''=>'---')+GxHtml::listDataEx(TiposFormulas::model()->findAll(array('condition'=>'estado=1'))),array('onchange'=>'js:modificarUnidad(this.value);')); 
                        	//echo $form->dropDownList($model, 'tipo_formula_id', array(''=>'---')+GxHtml::listDataEx(TiposFormulas::model()->findAll('estado=1'),'id','nombre',array('valor2'=>'formula')),array('onchange'=>'js:modificarUnidad(this.value);')); 
                        ?>
                        
                        <?php echo $form->error($model,'tipo_formula_id'); ?></td>
                         <div id="formula_para_calculo" style="display:none"></div>
                    </tr>
                    <tr>
				        <td align="right"><?php echo $form->labelEx($model,'unidad_id'); ?>:</td>
				        <td>
                        <?php   
                        	echo $form->hiddenField($model, 'unidad_id',array('value'=>''));                  
                       ?>
                       <div id="nombre_unidad"></div>
                      
                        <?php echo $form->error($model,'unidad_id'); ?></td>
				    </tr>
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'conceptoa'); ?></td>
                        <td>
                        <?php echo $form->textField($model, 'conceptoa', array('maxlength' => 9, 'onkeydown'=>'validarNumeros(event)','onChange'=>'calcularFormulaIndicadores()')); ?>
                        <?php echo $form->error($model,'conceptoa'); ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'conceptob'); ?></td>
                        <td>
                        <?php echo $form->textField($model,'conceptob', array('maxlength' => 9, 'onkeydown'=>'validarNumeros(event)','onChange'=>'calcularFormulaIndicadores()')); ?>
                        <?php echo $form->error($model,'conceptob'); ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'conceptoc'); ?></td>
                        <td>
                         <?php echo $form->textField($model, 'conceptoc', array('maxlength' => 9, 'onkeydown'=>'validarNumeros(event)','onChange'=>'calcularFormulaIndicadores()')); ?>
                        <?php echo $form->error($model,'conceptoc'); ?></td>
                    </tr>
				</table>
			</div>	
		</div>	
		
		<div class="fieldset2">
			<div class="legend">Descripción Fórmula y Medios de Verificación</div>
			<table border="0" cellspacing="5" cellpadding="5" width="100%">                    
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'formula'); ?></td>
                        <td>
                    <?php echo $form->textArea($model, 'formula', array('rows'=>2, 'cols'=>70)); ?>
                    <?php echo $form->error($model,'formula'); ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'medio_verificacion'); ?></td>
                        <td>
                    <?php echo $form->textArea($model, 'medio_verificacion', array('rows'=>2, 'cols'=>70)); ?>
                    <?php echo $form->error($model,'medio_verificacion'); ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'notas'); ?></td>
                        <td>
                    <?php echo $form->textArea($model, 'notas', array('rows'=>2, 'cols'=>70)); ?>
                    <?php echo $form->error($model,'notas'); ?></td>
                    </tr>
            </table>
		</div>	
		
		<div style='display: inline-block;'>	
			<div class="fieldset2" style='float:left;width: 230px;height: 150px;'>
				<div class="legend">Resultados Históricos del Indicador </div>
				<table border="0" cellspacing="5" cellpadding="5" width="100%">                    
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'efectivot3'); $t3 = $periodoActual-3; echo ' ('.$t3.')'; ?></td>
                        <td>
                    <?php echo $form->textField($model, 'efectivot3', array('maxlength' => 5,'size'=>5)); ?>
                    <?php echo $form->error($model,'efectivot3'); ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'efectivot2'); $t2 = $periodoActual-2; echo ' ('.$t2.')'; ?></td>
                        <td>
                    <?php echo $form->textField($model, 'efectivot2', array('maxlength' => 5,'size'=>5)); ?>
                    <?php echo $form->error($model,'efectivot2'); ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'efectivot1'); $t1 = $periodoActual-1; echo ' ('.$t1.')';?></td>
                        <td>
                    <?php echo $form->textField($model, 'efectivot1', array('maxlength' => 5,'size'=>5)); ?>
                    <?php echo $form->error($model,'efectivot1'); ?></td>
                    </tr>
                 </table>
			</div>	
			<div class="fieldset2" style='float:left;margin-left: 10px;height: 150px;width: 623px;'>
				<div class="legend">Metas año t (<?php echo $periodoActual ?>) </div>
				<table border="0" cellspacing="5" cellpadding="5" width="100%">                    
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'meta_anual'); ?></td>
                        <td>
                        <?php echo $form->textField($model, 'meta_anual', array('readonly' => 'readonly', 'onChange'=>'asignarValorDiciembre()')); ?>
                        <?php echo $form->error($model,'meta_anual'); ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'frecuencia_control_id'); ?></td>
                        <td>
                        <?php 
                        //Agregar onBlur="sumarMetasParciales(this)" a todos los input mes
                        if($buttons=='create'){                 
                            echo $form->dropDownList($model, 'frecuencia_control_id', array(''=>'---')+GxHtml::listDataEx(FrecuenciasControles::model()->findAll(array('condition'=>'estado=1'))),array('id'=>'frecuenciaControl', 'onchange'=>'js:metasParcialesInput(this.value);')); 
                        }else{
                            
                            $frecuencia = $model->frecuenciaControl;
                            echo $form->hiddenField($model, 'frecuencia_control_id');
                            echo ": <b>".$frecuencia."</b>";
                        }
                        ?>
                        <?php echo $form->error($model,'frecuencia_control_id'); ?></td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 100px;">Metas Parciales &nbsp;&nbsp;&nbsp;</td>
                        <td>
                            <div class='indicadores_meses'>Ene
                                <div class='indicadorMesInactivo' >
                                    <input name="Indicadores[enero]" class="meses" type="hidden" id="enero"  >
                                </div>
                            </div>
                            <div class='indicadores_meses'>Feb
                                <div class='indicadorMesInactivo' >
                                <input  name="Indicadores[febrero]"  class="meses" type="hidden" id="febrero" >
                                </div>
                            </div>
                            <div class='indicadores_meses'>Mar
                                <div class='indicadorMesInactivo' >
                                <input name="Indicadores[marzo]" class="meses" type="hidden" id="marzo" >
                                </div>
                            </div>
                            <div class='indicadores_meses'>Abr
                                <div class='indicadorMesInactivo' >
                                <input  name="Indicadores[abril]"  class="meses"type="hidden" id="abril" >
                                </div>
                            </div>
                            <div class='indicadores_meses'>May
                                <div class='indicadorMesInactivo' >
                                <input  name="Indicadores[mayo]" class="meses"type="hidden" id="mayo" >
                                </div>
                            </div>
                            <div class='indicadores_meses'>Jun
                                <div class='indicadorMesInactivo' >
                                <input  name="Indicadores[junio]" class="meses"type="hidden" id="junio" >
                                </div>
                            </div>
                            <div class='indicadores_meses'>Jul
                                <div class='indicadorMesInactivo' >
                                <input  name="Indicadores[julio]" class="meses"type="hidden" id="julio" >
                                </div>
                            </div>
                            <div class='indicadores_meses'>Ago
                                <div class='indicadorMesInactivo' >
                                <input name="Indicadores[agosto]"  class="meses"type="hidden" id="agosto" >
                                </div>
                            </div>
                            <div class='indicadores_meses'>Sep
                                <div class='indicadorMesInactivo'>
                                <input  name="Indicadores[septiembre]" class="meses"type="hidden"  id="septiembre" >
                                </div>
                            </div>
                            <div class='indicadores_meses'>Oct
                                <div class='indicadorMesInactivo' >
                                <input  name="Indicadores[octubre]" class="meses"type="hidden" id="octubre" >
                                </div>
                            </div>
                            <div class='indicadores_meses'>Nov
                                <div class='indicadorMesInactivo' >
                                <input name="Indicadores[noviembre]"  class="meses" type="hidden" id="noviembre" >
                                </div>
                            </div>
                            <div class='indicadores_meses'>Dic
                                <div class='indicadorMesInactivo' >
                                <input  name="Indicadores[diciembre]" class="meses" type="hidden" id="diciembre" >
                                </div>
                            </div>
                            <div class="limpia"></div>
                            <div class="limpia"></div>
                        
                        <?php 
                        $form->hiddenField($model, 'meta_parcial');
                        //echo $form->textField($model, 'meta_parcial', array('maxlength' => 200)); ?>
                        <?php //echo $form->error($model,'meta_parcial'); ?>
                        </td>
                    </tr>
                </table>
				<div class="content">					
					<div class="row">
						
					</div><!-- row -->				
				</div>
			</div>	
		</div>		
		
		<div class="fieldset2">
			<div class="legend">Supuestos</div>
			<table border="0" cellspacing="5" cellpadding="5" width="100%">                    
                    <tr>
                        <td align="right"><?php echo $form->labelEx($model,'supuestos'); ?></td>
                        <td><?php echo $form->textArea($model, 'supuestos',array('rows'=>2, 'cols'=>70)); ?>
                <?php echo $form->error($model,'supuestos'); ?></td>
                    </tr>
            </table>			
		</div>	
		
<!-- ######################################## -->


		

		<label><?php //echo GxHtml::encode($model->getRelationLabel('actividades')); ?></label>
		<?php //echo $form->checkBoxList($model, 'actividades', GxHtml::encodeEx(GxHtml::listDataEx(Actividades::model()->findAll(array('condition'=>'estado=1'))), false, true)); ?>
		<label><?php //echo GxHtml::encode($model->getRelationLabel('tiposIndicadores')); ?></label>
		<?php echo $form->checkBoxList($model, 'tiposIndicadores', GxHtml::encodeEx(GxHtml::listDataEx(TiposIndicadores::model()->findAll(array('condition'=>'estado=1'))), false, true)); ?>

		<div class="row buttons">        
        	<?php 
        	//echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar',array('onclick'=>'validarMetasParciales()'));
        	echo '<input type="button" value="Guardar" name="yt0" onclick="validarMetasParciales()">'
        	//echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); 
        	?>      
   		 </div>
<?php
if($buttons=='update'){	
	echo '<script type="text/javascript">metasParcialesInput("'.$frecuencia.'");</script>';
	foreach($hitosIndicadores as $row){
		echo '<script type="text/javascript"> document.getElementById("'.$row->mes.'").value = "'.$row->meta_parcial.'" </script>';
	}

	
}
//echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div>

