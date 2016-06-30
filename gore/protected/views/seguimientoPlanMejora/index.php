<?php
Yii::app()->clientScript->registerScript('init', "
		$( '#tabs' ).tabs();
");	
$this->breadcrumbs = array(
		Yii::t('ui','Reportes')=>array('/reportes'),
		'Seguimiento Plan de Mejora',
);
date_default_timezone_set("America/Santiago");

$mes = date("F");
$anio = date("Y");
$dia = date("d");
if ($mes=="January") $mes="Enero";
if ($mes=="February") $mes="Febrero";
if ($mes=="March") $mes="Marzo";
if ($mes=="April") $mes="Abril";
if ($mes=="May") $mes="Mayo";
if ($mes=="June") $mes="Junio";
if ($mes=="July") $mes="Julio";
if ($mes=="August") $mes="Agosto";
if ($mes=="September") $mes="Setiembre";
if ($mes=="October") $mes="Octubre";
if ($mes=="November") $mes="Noviembre";
if ($mes=="December") $mes="Diciembre";

$fecha = $mes.' '.$dia.' de '.$anio;

//trayendo los datos de amis
$amis = LineasAccion::model()->busquedaAmiReporte(0);
$amis = $amis->getData();

$lineas = LineasAccion::model()->busquedaAmiReporte(1);
$lineas = $lineas->getData();

$totalActual=0.0;
$totalEsperado=0.0;
$totalPonderado=0.0;
$totalActual2=0.0;
$totalEsperado2=0.0;
$totalPonderado2=0.0;
$totalRevisado = 0.0;
$totalRevisadoPonderado = 0.0;
$totalRevisado2 = 0.0;
$totalRevisadoPonderado2 = 0.0;
?>
<div style="float:right;" id='contenedoricono' class='botoenesReportecdc'>
<div style="float:left">Exportar a:&nbsp&nbsp&nbsp</div>
<a id="linkExcel"  name="linkExcel" title="Exportar a Pdf" href="<?php  echo Yii::app()->request->baseUrl.'/seguimientoPlanMejora/reportes?pdf=1&fecha='.$fecha; ?>" >
<div class="iconoPdf" id ="iconoPdf" style="float:right"></div></a>
<a id="linkExcel"  name="linkExcel" title="Exportar a MS Word" href="<?php echo Yii::app()->request->baseUrl.'/seguimientoPlanMejora/reportes?doc=1&fecha='.$fecha; ?>" >
<div class="iconoWord" id ="iconoWord" style="float:right"></div></a>
</div>
<br></br>
<!-- INICIO TABS -->
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">AMI</a></li>
    <li><a href="#tabs-2">Lineas de Acción</a></li>
  </ul>
  <div id="tabs-1">
  <!-- inicio primer tab -->
    	<table width="917" height="220" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
		  <tr>
		    <td colspan="8" bgcolor="#6095BD" class="textoReportesTablas"><center>SEGUIMIENTO AMI</center></td>
		  </tr>
		  <tr>
		    <td width="267" bgcolor="#6095BD" class="textoReportesTablas">Gobierno Regional</td>
		    <td colspan="7">&nbsp;Gobierno Regional de Los Lagos</td>
		  </tr>
		  <tr>
		    <td bgcolor="#6095BD" class="textoReportesTablas">Fecha</td>
		    <td colspan="7">&nbsp;<?php echo $fecha; ?></td>
		  </tr>
		  <tr>
		    <td bgcolor="#6095BD" class="textoReportesTablas">Responsable</td>
		    <td colspan="7">&nbsp;</td>
		  </tr>
		  <tr>
		    <td height="67" colspan="8">
		    <!-- inicio tabla intermedia -->
		    <div style="max-height:600px;overflow:auto;height:auto;">
		    <table width="870" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
		      <tr>
		        <td width="98" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>AMI</center></td>
		        <td width="161" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Elemento de Gestión (EG)</center></td>
		        <td colspan="3" bgcolor="#6095BD" class="textoReportesTablas"><center>Puntaje</center></td>
		        <td width="119" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Delta Ponderado Esperado</center></td>
		        <td width="124" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Delta Ponderado Validado</center></td>
		        <td width="90" rowspan="2" bgcolor="#6095BD" >&nbsp;</td>
		      </tr>
		      <tr>
		        <td width="94" bgcolor="#6095BD" class="textoReportesTablas"><center>Actual</center></td>
		        <td width="103" bgcolor="#6095BD" class="textoReportesTablas"><center>Esperado</center></td>
		        <td width="68" bgcolor="#6095BD" class="textoReportesTablas"><center>Validado</center></td>
		        </tr>
		        <?php 
		        
		        for($j=0; $j<count($amis); $j++){

				//trayendo los elementos
				$elementos = LaElemGestion::model()->elementosGestionPorAmi($amis[$j]['id']);
				
		        ?>
			      <tr>
			        <td>&nbsp;<?php echo $amis[$j]['nombre']; ?></td>
			        <?php //for($k=0; $k<count($elementos);$k++){ ?>
			        <td>&nbsp;
			        <?php 
			        //mostrando elementos gestion nombre
			       	 
			       	 
		        	 for($k=0; $k<count($elementos); $k++){
		        	 	
					      if($k==0){
					        		echo $elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					       }else{
					        			
					       		if(($k+1)%3==0){
					        		echo ';<br/>&nbsp;&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        	}else{
					        		echo ';&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        	}
					        }
				      }//fin for
			        
			        ?>
			        </td>
			        <td>&nbsp;
			        <?php 
			        //mostrando el puntaje actual
				        	for($k=0; $k<count($elementos); $k++){
				        		
				        		
					        		if($k==0){
					        			echo $elementos[$k]['puntaje_actual'];
					        		}else{
					        			
					        			if(($k+1)%3==0){
					        				echo  ';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}else{
					        				echo  ';&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}
					        		}
					        			$totalActual = $totalActual+$elementos[$k]['puntaje_actual'];
					        	
				        	
				        	}//fin for
				    ?>
			        </td>
			        <td>&nbsp;
			        <?php 
			        //mostrando puntaje esperado
			        $puntajeEsperadoArr=array();
			        $deltasPonderado = array();
			        $puntajeEsperadoArr[0]['puntaje_esperado']=0;
			  
				       	for($k=0; $k<count($elementos); $k++){
							$deltaPonderado[$k]['delta']='S.I.';
							$puntajeEsperadoArr = LaElemGestion::model()->findAll(array('condition'=>'t.estado = 1 AND t.id_la IS NOT NULL AND t.id_elem_gestion='.$elementos[$k]['idElem'].' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'select'=>'t.puntaje_esperado'));
				       		
					        		if($k==0){
					        			echo $puntajeEsperadoArr[0]['puntaje_esperado'];
					        		}else{
					        			if(($k+1)%3==0){
					        				echo  ';<br/>&nbsp;&nbsp;'.$puntajeEsperadoArr[0]['puntaje_esperado'];
					        			}else{
					        				echo  ';&nbsp;'.$puntajeEsperadoArr[0]['puntaje_esperado'];
					        			}
					        		}
					        	
					        			$totalEsperado = $totalEsperado+$puntajeEsperadoArr[0]['puntaje_esperado'];
					        	$deltasPonderado[$k]['delta'] = ($puntajeEsperadoArr[0]['puntaje_esperado']-$elementos[$k]['puntaje_actual'])*$elementos[$k]['puntaje_elemento'];
				        }//fin for
				       
				    ?>
			        </td>
			        <td>&nbsp;
			        <?php 
			        //mostrando puntaje medido = revisado
			        		$puntajeRevisadoArr=array();
			        		$puntajeRevisadoArr[0]['revisado']=0;
			        		$deltaRevisado=array();
				        	for($k=0; $k<count($elementos); $k++){
								$deltaRevisado[$k]['revisado']='S.I.';
								$puntajeRevisadoArrSQL = LaElemGestion::model()->findAll(array('condition'=>'t.puntaje_revisado IS NOT NULL AND id_la IS NULL AND t.id_elem_gestion='.$elementos[$k]['idElem'].' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'order'=>'t.fecha DESC','select'=>'t.puntaje_revisado'));
					            $puntaje_revisado=0;
					            if(isset($puntajeRevisadoArrSQL[0])){
					                $puntaje_revisado=$puntajeRevisadoArrSQL[0]['puntaje_revisado'];
					            }
				        		//if(!is_null($puntajesUltimos1[0]['puntaje_revisado'])){
					        		if($k==0){
					        			echo $puntaje_revisado;
					        		}else{
					        			if(($k+1)%3==0){
					        				echo  ';<br/>&nbsp;&nbsp;'.$puntaje_revisado;
					        			}else{
					        				echo  ';&nbsp;'.$puntaje_revisado;
					        			}
					        		}
					        			$totalRevisado = $totalRevisado+$puntaje_revisado;
					        			$deltaRevisado[$k]['revisado'] = ($puntaje_revisado-$elementos[$k]['puntaje_actual'])*$elementos[$k]['puntaje_elemento'];
				        }
				    ?>
			        </td>
			        <td>&nbsp;
			        <?php 
				         	$resultado = 0.0;
				        	for($k=0; $k<count($deltasPonderado); $k++){
				        		//$resultado = $resultado+($elementos[$k]['puntaje_esperado']-$elementos[$k]['puntaje_actual'])*$elementos[$k]['puntaje_elemento'];
				        		if($deltasPonderado[$k]['delta']!='S.I.'){
									$resultado = $resultado+$deltasPonderado[$k]['delta'];
								}
				        		
				        	}
				        	echo $resultado;
				        	$totalPonderado = $totalPonderado+$resultado;
				        	
				    ?>
			        </td>
			        <td>&nbsp;
			        <?php 
				         	$resultadoR = 0.0;
				        	for($k=0; $k<count($deltaRevisado); $k++){
				        	
				        		$resultadoR = $resultadoR+$deltaRevisado[$k]['revisado'];
				        		
				        	}
				        	echo $resultadoR;
				       
				        	$totalRevisadoPonderado = $totalRevisadoPonderado+$resultadoR;
				    ?>
				    
			        </td>
			        
			        <td>&nbsp;
			        <a href="<?php echo Yii::app()->request->baseUrl.'/seguimientoPlanMejora/update?id='.$amis[$j]['id'].'&t=0' ?>">
					 <img src="<?php echo Yii::app()->request->baseUrl.'/images/view.png'; ?>" />
					</a>
			        </td>
			      </tr>
		      <?php 
		      		
		        }//fin for principal
		      ?>
		    </table>
		    </div>
		    <!-- fin tabla intermedia -->
		    <!-- inicio tabla de comentarios/observaciones -->
		    <!-- fin tabla comentarios/observaciones -->
		    </td>
		  </tr>
		  <tr>
		    <td colspan="2" bgcolor="#6095BD" class="textoReportesTablas">Sub Total AMI</td>
		    <td width="100">&nbsp;<?php echo $totalActual; ?></td>
		    <td width="101">&nbsp;<?php echo $totalEsperado; ?></td>
		    <td width="70">&nbsp;<?php echo $totalRevisado; ?></td>
		    <td width="127">&nbsp;<?php echo $totalPonderado; ?></td>
		    <td width="128">&nbsp;<?php echo $totalRevisadoPonderado; ?></td>
		    <td width="96">&nbsp;</td>
		  </tr>
		</table>
 
 <!-- fin primer tab -->   
  </div>
  <div id="tabs-2">
    <!-- inicio tabs 2 -->
    
    <table width="917" height="220" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
	  <tr>
	    <td colspan="8" bgcolor="#6095BD" class="textoReportesTablas"><center>SEGUIMIENTO LÍNEAS DE ACCIÓN</center></td>
	  </tr>
	  <tr>
	    <td width="267" bgcolor="#6095BD" class="textoReportesTablas">Gobierno Regional</td>
	    <td colspan="7">&nbsp;Gobierno Regional de Los Lagos</td>
	  </tr>
	  <tr>
	    <td bgcolor="#6095BD" class="textoReportesTablas">Fecha</td>
	    <td colspan="7">&nbsp;<?php echo $fecha; ?></td>
	  </tr>
	  <tr>
	    <td bgcolor="#6095BD" class="textoReportesTablas">Responsable</td>
	    <td colspan="7">&nbsp;</td>
	  </tr>
	  <tr>
	    <td height="67" colspan="8">
	    <!-- inicio tabla intermedia -->
	    <div style="max-height:600px;overflow:auto;height:auto;">
	    <table width="870" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
	      <tr>
	        <td width="98" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>LÍNEAS DE ACCIÓN</center></td>
	        <td width="179" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Elemento de Gestión (EG)</center></td>
	        <td colspan="3" bgcolor="#6095BD" class="textoReportesTablas"><center>Puntaje</center></td>
	        <td width="119" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Delta Ponderado Esperado</center></td>
	        <td width="134" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Delta Ponderado Validado</center></td>
	        <td width="101" rowspan="2" bgcolor="#6095BD">&nbsp;</td>
	      </tr>
	      <tr>
	        <td width="94" bgcolor="#6095BD" class="textoReportesTablas"><center>Actual</center></td>
	        <td width="103" bgcolor="#6095BD" class="textoReportesTablas"><center>Esperado</center></td>
	        <td width="68" bgcolor="#6095BD" class="textoReportesTablas"><center>Validado</center></td>
	        </tr>  
	      <?php 
	      for($i=0; $i<count($lineas); $i++){
	      ?>
	      <tr>
	        <td>&nbsp;<?php echo $lineas[$i]['nombre']; ?></td>
	        <td>&nbsp;
	        <?php     
			 $elementos2 = LaElemGestion::model()->elementosGestionPorAmi($lineas[$i]['id']);
			       	 
		     for($k=0; $k<count($elementos2); $k++){
				if($k==0){
					 echo $elementos2[$k]['n_criterios'].'.'.$elementos2[$k]['n_subcriterios'].'.'.$elementos2[$k]['n_elementos'];
				}else{
					 if(($k+1)%3==0){
					    echo ';<br/>&nbsp;&nbsp;'.$elementos2[$k]['n_criterios'].'.'.$elementos2[$k]['n_subcriterios'].'.'.$elementos2[$k]['n_elementos'];
					 }else{
					    echo ';&nbsp;'.$elementos2[$k]['n_criterios'].'.'.$elementos2[$k]['n_subcriterios'].'.'.$elementos2[$k]['n_elementos'];
					 }
				}
			}//fin for
			        
			?>
	        </td>
	        <td>&nbsp;
	        <?php 
	      	for($k=0; $k<count($elementos2); $k++){
				        		
				if(!is_null($elementos2[$k]['puntaje_actual'])){
					 if($k==0){
					       echo $elementos2[$k]['puntaje_actual'];
					  }else{
					        			
					      if(($k+1)%3==0){
					        echo  ';<br/>&nbsp;&nbsp;'.$elementos2[$k]['puntaje_actual'];
					      }else{
					        echo  ';&nbsp;'.$elementos2[$k]['puntaje_actual'];
					      }
					   }
				//	 if(!empty($elementos2[$k]['puntaje_actual'])){
					  $totalActual2 = $totalActual2+$elementos2[$k]['puntaje_actual'];
				//	 }
				}//fin if
			}
			?>
	        </td>
	        <td>&nbsp;
	        <?php 
	        $puntajesEsperadoArr2=array();
	        $puntajesEsperadoArr2[0]['puntaje_esperado']=0;
	        $arrayDelta=array();
	        for($k=0; $k<count($elementos2); $k++){
				$arrayDelta[$k]['delta']='S.I.';
				$puntajesEsperadoArr2 = LaElemGestion::model()->findAll(array('condition'=>'t.estado = 1 AND t.id_la IS NOT NULL AND t.id_elem_gestion='.$elementos2[$k]['idElem'].' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'select'=>'t.puntaje_esperado'));
				$puntaje_esperado=0;
				if(isset($puntajesEsperadoArr2[0])){
				    $puntaje_esperado=$puntajesEsperadoArr2[0]['puntaje_esperado'];
				}
					 if($k==0){
					     echo $puntaje_esperado;
					 }else{
					     if(($k+1)%3==0){
					        echo  ';<br/>&nbsp;&nbsp;'.$puntaje_esperado;
					     }else{
					        echo  ';&nbsp;'.$puntaje_esperado;
					     }
					 }
			
					$totalEsperado2 = $totalEsperado2+$puntaje_esperado;
					$arrayDelta[$k]['delta']=($puntaje_esperado-$elementos2[$k]['puntaje_actual'])*$elementos2[$k]['puntaje_elemento'];
			}//fin for
	        
	        ?>
	        </td>
	        <td>&nbsp;
	 		<?php 
	 			$arrayRevisado2=array();
	 			$arrayRevisado2[0]['revisado']=0;
	 			$deltaRevisado2=array();
				for($k=0; $k<count($elementos2); $k++){
					$deltaRevisado2[$k]['revisado']='S.I.';
					$arrayRevisado2 = LaElemGestion::model()->findAll(array('condition'=>'t.puntaje_revisado IS NOT NULL AND id_la IS NULL AND t.id_elem_gestion='.$elementos2[$k]['idElem'].' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'order'=>'t.fecha DESC','select'=>'t.puntaje_revisado'));
					$puntaje_revisado=0;
                    if(isset($arrayRevisado2[0])){
                        $puntaje_revisado=$arrayRevisado2[0]['puntaje_revisado'];
                    }
					    if($k==0){
					        echo $puntaje_revisado;
					      }else{
					        if(($k+1)%3==0){
					        	echo  ';<br/>&nbsp;&nbsp;'.$puntaje_revisado;
					        }else{
					        	echo  ';&nbsp;'.$puntaje_revisado;
					        }
					      }
					    
					      $totalRevisado2 = $totalRevisado2+$puntaje_revisado;
					   	  $deltaRevisado2[$k]['revisado']= ($puntaje_revisado-$elementos2[$k]['puntaje_actual'])*$elementos2[$k]['puntaje_elemento'];
				    
				  }//fin for
			?>
	        </td>
	        <td>&nbsp;
	        <?php 
				$resultado = 0.0;
				for($k=0; $k<count($arrayDelta); $k++){
					if($arrayDelta[$k]['delta']!='S.I.'){
						$resultado = $resultado+$arrayDelta[$k]['delta'];
					}
				}
				echo $resultado;
				$totalPonderado2 = $totalPonderado2+$resultado;
			?>
	        </td>
	        <td>&nbsp;
	        <?php 
	        	$resultadoX = 0.0;
				for($k=0; $k<count($deltaRevisado2); $k++){
					$resultadoX = $resultadoX+$deltaRevisado2[$k]['revisado'];
				}
				echo $resultadoX;
				$totalRevisadoPonderado2 = $totalRevisadoPonderado2+$resultadoX;
	        
	        
	        ?>
	        </td>
	        <td>&nbsp;
	         <a href="<?php echo Yii::app()->request->baseUrl.'/seguimientoPlanMejora/update?id='.$lineas[$i]['id'].'&t=1' ?>">
				<img src="<?php echo Yii::app()->request->baseUrl.'/images/view.png'; ?>" />
			 </a>
	        </td>
	      </tr>
	      <?php 
	      }//fin for
	      ?>
	    </table>
	    </div>
	    </td>
	  </tr>
	  <tr>
	    <td colspan="2" bgcolor="#6095BD" class="textoReportesTablas">Sub Total AMI</td>
	    <td width="90">&nbsp;<?php echo $totalActual2; ?></td>
	    <td width="100">&nbsp;<?php echo $totalEsperado2; ?></td>
	    <td width="63">&nbsp;<?php echo $totalRevisado2; ?></td>
	    <td width="120">&nbsp;<?php echo $totalPonderado2; ?></td>
	    <td width="132">&nbsp;<?php echo $totalRevisadoPonderado2; ?></td>
	    <td width="95">&nbsp;
	   
	    </td>
	  </tr>
	</table>
    
    <!-- fin tabs 2 -->
  </div>

</div>