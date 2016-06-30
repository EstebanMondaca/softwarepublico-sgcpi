<?php

$this->breadcrumbs = array(
	'Selección elemento gestión' => array('index'),
	'Evidencia Control de Gestión',
);

Yii::app()->clientScript->registerScript('disenio', "
    $(document).ready(function() {
        $('#versionesRegistro tbody tr').bind('click', function() {
            cambiarSeleccionFecha(this);
        });
        
        //Activando primer tr del formulario
        $('#versionesRegistro tbody tr').eq(-1).click();
        
        $('.datepicker').datepicker({'dateFormat':'yy-mm-dd','monthNames':['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],'monthNamesShort':['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],'dayNames':['Domingo,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado'],'dayNamesMin':['Do','Lu','Ma','Mi','Ju','Vi','Sa']});
    });
");

?>

<div class="form">


<?php 
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCssFile(
    Yii::app()->clientScript->getCoreScriptUrl().
        '/jui/css/base/jquery-ui.css'
    );
    $form = $this->beginWidget('GxActiveForm', array(
    'id' => 'elementos-gestion-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'class'=>'controlElementosGestion'
    ),
));
?>
    <?php 
    echo "<h3>Evidencia Control de Gestión</h3>";
    ?>
        <?php echo $form->errorSummary($model); ?>
        <table width="100%" border="0" cellspacing="5" cellpadding="5" class="control">
          <tr>
            <td valign="top" width="23%" rowspan="3">
                <div class="fieldset2" style='height: 428px;'>
                    <div class="legend">Versiones del registro</div>                    
                    <div class="grid-view overflow" style="height: 372px;"> 
                        <table class="items" id="versionesRegistro">
                            <thead>
                              <tr><th style="width:25px;">Ver</th><th>Fecha</th></tr>
                            </thead>
                            <tbody>
                                 <?php                                      
                                      $x=1;                                                        
                                      foreach($model->laElemGestions as $v):
                                        if($v->idPlanificacion->id==Yii::app()->session['idPlanificaciones']){
                                              if(empty($v->id_la)){
                                                  $anio=Yii::app()->dateFormatter->format('dd MMM, yyyy', $v->fecha);
                                                  $anioInput=Yii::app()->dateFormatter->format('yyyy-MM-dd', $v->fecha);
                                                  $parOImpar=$x%2?"even":"odd";                                              
                                                 if($v->puntaje_revisado!=null && $v->puntaje_revisado!=''){
                                                     echo "<tr valueTr='laElemGestions_".$v->id."' class=".$parOImpar.">";
                                                    echo "<td>V".$x."</td>";
                                                    echo "<td>".$anio."</td>";
                                                    echo "</tr>";
                                                    $x++;  
                                                 }
                                              }
                                          }
                                      endforeach;
                                      
                                      if($x==1){
                                        echo "<tr><td colspan='2'>No existen versiones validadas.</td></tr>";   
                                      }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="mensajeVersionesRegistro" class="errorMessage" style="display:none"></div>
                    <div> 
                        <div class="limpia"></div>
                    </div>
                </div> 
            </td>
            <td valign="top" colspan="3">
                <div class="fieldset2">
                    <div class="legend">Criterio</div>                    
                    <strong><?php echo $model->idSubcriterio->idCriterio;?></strong>
                    <div style="height:70px;overflow: auto;">
                        <?php echo $model->idSubcriterio->idCriterio->descripcion;?>
                    </div>
                </div>                
            </td>
          </tr>
          <tr>
            <td valign="top" width="23%">
                <div class="fieldset2">
                    <div class="legend">SubCriterio</div> 
                    <div style="height:63px;overflow: auto;width: 232px;">                   
                        <?php echo $model->idSubcriterio;?>
                        <?php echo $model->idSubcriterio->descripcion;?>
                    </div>
                </div>  
            </td>
            <td valign="top" colspan="2">
                <!--Inicio de tabla con puntajes de evidencia-->                
                    <table class="evidencia" width="100%" border="1" cellspacing="0" cellpadding="0">
                       <thead> 
                      <tr align="center">
                        <th width="18%">No Hay despliegue</th>
                        <th colspan="2">Despliegue parcial</th>
                        <th colspan="3">Despliegue total</th>
                      </tr>
                      </thead>
                      <tbody>
                          <tr align="center" class='even'>
                            <td>No Hay enfoque</td>
                            <td width="16%">Enfoque incipiente </td>
                            <td width="16%">Enfoque sistematico</td>
                            <td width="16%">Enfoque evaluado</td>
                            <td width="16%">Enfoque mejorado</td>
                            <td >Enfoque efectivo</td>
                          </tr>
                          <tr align="center">
                            <td id="despliegue0">0</td>
                            <td id="despliegue1">1</td>
                            <td id="despliegue2">2</td>
                            <td id="despliegue3">3</td>
                            <td id="despliegue4">4</td>
                            <td id="despliegue5">5</td>
                          </tr>
                      </tbody>
                    </table>
                <!--fin de tabla con puntajes de evidencia-->
                
            </td>
          </tr>
          <tr>
            <td valign="top">
                <div class="fieldset2" style='height: 196px;'>
                    <div class="legend">E. Gestión</div>                    
                    <div style="height:169px;overflow: auto;width: 232px;">
                        <?php echo $model->nombre;?>
                    </div>
                </div> 
            </td>
            <td valign="top" colspan="2">
                 <div id="laElemGestions_evidencia" class="fieldset2" style="height: 196px;">
                    <div class="legend">Evidencia</div>  
                    <?php
                        foreach($model->laElemGestions as $v):
                            if($v->idPlanificacion->id==Yii::app()->session['idPlanificaciones']){
                                if($v->puntaje_revisado!=null && $v->puntaje_revisado!=''){
                                    echo '<div class="textareabootstrap laElemGestions_'.$v->id.'" id="laElemGestions_'.$v->id.'_evidencia" style="width: 390px;display:none;height: 169px;">'.$v->evidencia.'</div>';
                                }
                            }
                        endforeach;
                    ?>
                    <div id="mensajeEvidencia" class="errorMessage" style="display:none">Evidencia no puede ser nulo.</div>
                </div> 
            </td>
          </tr>
          <tr>
            <td valign="top" rowspan="2">
                <div class="fieldset2">
                    <div class="legend">Calificaciones</div>                    
                    Responsable: <br/><strong><?php echo (isset($model->elementosGestionResponsables[0]))?$model->elementosGestionResponsables[0]->responsable->nombreycargo[0]:""; ?></strong>
                    <div class="fieldset2">                                          
                        <div style="font-size: 13px; text-align: center;">
                            <table>
                                <tr>
                                    <td align="left">Puntaje Revisado:</td>
                                    <td><b><?php 
                                        echo $model->ultimoPuntajeRevisado;                          
                                    ?></b></td>
                                </tr>
                                <tr>
                                    <td align="left">Puntaje Actual:</td>
                                    <td><b>
                         <?php 
                              echo $model->ultimoPuntajeActual;                          
                        ?></b></td>
                                </tr>
                            </table>
                        </div>
                    </div> 
                </div> 
            </td>
            <td valign="top" colspan="2" rowspan="2">
                 <div id="laElemGestions_archivo" class="fieldset2">
                    <div class="legend">Documento con Evidencia de Avance</div>       
                    <?php                         
                        $origenUrl= Yii::app()->request->baseUrl.'/upload/controlElementosGestion/';  
                        foreach($model->laElemGestions as $v):
                            if($v->idPlanificacion->id==Yii::app()->session['idPlanificaciones']){
                                if($v->puntaje_revisado!=null && $v->puntaje_revisado!=''){
                                	$modelDocument = LaElemGestionDocumentos::model()->findAll(array('condition'=>'t.la_elem_id='.$v->id .' AND estado = 1'));
				       				if (isset($modelDocument[0]['nombre'])){
				       					echo '<b class="laElemGestions_'.$v->id.' file"></br> Documentos Almacenados :</b>';
				       					echo '<div class="laElemGestions_'.$v->id.' file" style="height:80px;overflow-x: hidden;overflow-y: scroll;width: 248px;"><table style="width:230px;">';
				       					foreach($modelDocument as $itemsDoc){
											$nombreDoc = $itemsDoc->nombre;
				       						$temp_nombre= 	substr($nombreDoc,14);
					       					 $nombre_archivo = substr($temp_nombre,0, 20);
					       					 if(strlen($temp_nombre)>20){$nombre_archivo .= "...";}
											 echo '<tr class="laElemGestions_'.$itemsDoc->la_elem_id.' file" id="laElemGestions_'.$itemsDoc->id.'_archivo" style="display:none;"><td>'.$nombre_archivo.'</td><td><a href="'.$origenUrl.$itemsDoc->nombre.'" target="_blank"><img src="'.Yii::app()->request->baseUrl.'/images/view.png"/></a></td></tr>';
				       					}
				       					echo '</table></div>';
				       				}	
                                    //echo '<div class="laElemGestions_'.$v->id.' file" id="laElemGestions_'.$v->id.'_archivo" style="display:none;"><a href="'.$origenUrl.$v->archivo.'"><img src="'.Yii::app()->request->baseUrl.'/images/document_letter_download.png"/> Descargar archivo</a></div>';
                                }
                            }
                        endforeach;
                    ?>
                    <div id="mensajeArchivo" class="errorMessage" style="display:none">Documento con Evidencia de Avance no puede ser nulo.</div>
                    <div id="mensajeArchivo2" class="errorMessage typeFile" style="display:none">Documento con Evidencia de Avance debe ser un PDF.</div>
                </div> 
            </td>
            <td valign="top" width="33%">
                <div id="laElemGestions_puntaje_real" class="fieldset2">
                    <div  class="legend">Calificación Propuesta</div>   
                    <?php                        
                        foreach($model->laElemGestions as $v):
                            if($v->idPlanificacion->id==Yii::app()->session['idPlanificaciones']){
                               if($v->puntaje_revisado!=null && $v->puntaje_revisado!=''){                                  
                                   echo "<div id='laElemGestions_".$v->id."_puntaje_real' class='selectbootstrap laElemGestions_".$v->id."' style='display:none;'>".$v->puntaje_revisado."</div>";
                               }            
                            }                   
                        endforeach; 
                    ?>                 
                    <?php 
                    /*echo $form->labelEx($model,'evidencia'); 
                    echo $form->textArea($model, 'evidencia'); 
                    echo $form->error($model,'evidencia'); */
                   ?>
                </div> 
            </td>
          </tr>
          <tr>
            <td>
                &nbsp;
            </td>
          </tr>
        </table>    
<?php
$this->endWidget();
?>
</div><!-- form -->