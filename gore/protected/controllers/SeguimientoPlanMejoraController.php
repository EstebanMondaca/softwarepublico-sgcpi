<?php
include dirname(Yii::app()->request->scriptFile).'/protected/views/panelAvances/ConsultasView.php';

class SeguimientoPlanMejoraController extends GxController {

    public function filters() {
    return array(
            'accessControl', 
            );
    }
    
    public function accessRules() {                  
          return array(
            array('allow',
                'actions'=>array('index','reportes', 'update', 'viewla', 'viewIndicador', 'addComentario', 'obtenerObservacion'),    
            	'roles'=>array('gestor','finanzas','supervisor','supervisor2'),            
            
            ),             
            array('deny',
                'users'=>array('*'),
            ),
        );
    }  


public function actionIndex() {

		
		$this->render('index'
		);
}

public function actionUpdate($id, $t){
		$titulo = '';
	
		$datosAmi= LineasAccion::model()->unaAmiDetalles($id, 0);
		if($t==1){
			$titulo = 'SEGUIMIENTO DE LÍNEA DE ACCIÓN';
		}else{
			$titulo = 'SEGUIMIENTO DE ACCIÓN DE MEJORA INMEDIATA';
		}
		
       	$this->render('view', array(
                'datosAmi'=>$datosAmi,
       			'id'=>$id,
       			'titulo'=>$titulo,
        ));
}

public function actionViewla($id){
	$lineas = LineasAccion::model()->lineasIndicador($id);
		$this->layout = '//layouts/iframe';
		    	$this->render('viewLA', array(
                'lineas'=>$lineas,
		    	'id'=>$id
     
        ));
}
public function actionViewIndicador($idi) {
		
	date_default_timezone_set("America/Santiago");

	    $anio = date("Y");
	    $dia = date("d");
	    $mesNombre=date("F");
	    $numeroMesActual = date("m");
	    $fecha = $anio.'-'.$numeroMesActual.'-'.$dia;
	    
	    //cambiando nombre meses
	    if ($mesNombre=="January") $mesNombre="enero";
		if ($mesNombre=="February") $mesNombre="febrero";
		if ($mesNombre=="March") $mesNombre="marzo";
		if ($mesNombre=="April") $mesNombre="abril";
		if ($mesNombre=="May") $mesNombre="mayo";
		if ($mesNombre=="June") $mesNombre="junio";
		if ($mesNombre=="July") $mesNombre="julio";
		if ($mesNombre=="August") $mesNombre="agosto";
		if ($mesNombre=="September") $mesNombre="septiembre";
		if ($mesNombre=="October") $mesNombre="octubre";
		if ($mesNombre=="November") $mesNombre="noviembre";
		if ($mesNombre=="December") $mesNombre="diciembre";
		//fin cambiando nombre a los meses
	    
		$indi = array();
		$indi= Indicadores::model()->indicadorUnUsuario($idi);
		if(!empty($indi)){
		$auxiliar=array();
		for ($i=0; $i<count($indi);$i++){
			
			$c = new ConsultasView();
		
		
			if(!empty($indi[$i]['id'])&&$indi[$i]['plazo_maximo']){
				//echo 'entro a for';
			
				$auxiliar = $c->construyendoBarras($indi[$i]['id'],$indi[$i]['plazo_maximo']);
				 
				 if($auxiliar['value'] != -1 && $auxiliar['value']>=0){
				 	$indi[$i]['value'] = $auxiliar['value'];
				 }else{
				 	$indi[$i]['value'] = 'S.I.';
				 }
				 if($auxiliar['fecha']!= -1 && !empty($auxiliar['fecha'])){
				 	$indi[$i]['fecha'] = $auxiliar['fecha'];
				 }
				 else{
				 	$indi[$i]['fecha'] = 'S.I.';
				 }
				 if($auxiliar['meta'] != -1 && $auxiliar['meta']>=0){
					 $indi[$i]['esperado'] = $auxiliar['meta'];
				 }else{
				 	$indi[$i]['esperado']='S.I.';
				 }
				if(!empty($indi[$i]['frecuencia'])){
				 	$indi[$i]['frecuencia'] = $indi[$i]['frecuencia'];
				}else{
					$indi[$i]['frecuencia'] = 'S.I.';
				}
				 if($indi[$i]['ascendente']==1){//indicadore es ascendente
				 	
				 	$indi[$i]['value']=$indi[$i]['value'];
				 	$indi[$i]['ascendente1']= 'Ascendente';
				 	
				 }else{//sino descendente
				 	if($indi[$i]['ascendente']==0){
					 	$indi[$i]['value']=$indi[$i]['value'];
					 	$indi[$i]['ascendente1']= 'Descendente';
				 	}
				 }
			}//fin if si no vienen parametros vacios
			else{
				//for ($i=0; $i<count($indi);$i++){
					//echo 'entro al otro for';
				
				$indi[$i]['value'] = 'S.I.';
				$indi[$i]['fecha'] = 'S.I.';
				$indi[$i]['esperado']='S.I.';
				
				if(!empty($indi[$i]['frecuencia'])){
				 	$indi[$i]['frecuencia'] = $indi[$i]['frecuencia'];
				}else{
					$indi[$i]['frecuencia'] = 'S.I.';
				}
				 if($indi[$i]['ascendente']==1){//indicadore es ascendente
				 	
				 	$indi[$i]['value']=$indi[$i]['value'];
				 	$indi[$i]['ascendente1']= 'Ascendente';
				 	
				 	
				 }else{//sino descendente
				 	if($indi[$i]['ascendente']==0){
					 	$indi[$i]['value']=$indi[$i]['value'];
					 	$indi[$i]['ascendente1']= 'Descendente';
				 	}
				}
			//}//fin for
			}
	
		}//fin for
		}
	
		$hitos=HitosIndicadores::model()->findAll(array('condition'=>'t.estado=1 AND t.id_indicador='.$idi));
		$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		
		$datosActividad = Actividades::model()->actividadesHitos($mesNombre,$idi);
		$datosActividad = $datosActividad->getData();
		
		for($i=0; $i<count($datosActividad);$i++){

			if(empty($datosActividad[$i]['avance_actual'])){
				$datosActividad[$i]['avance_actual']='S.I.';
			}
			if(isset($datosActividad[$i]['fecha_inicio'])&&isset($datosActividad[$i]['fecha_termino'])&&isset($fecha)){
				$fechaIni=strtotime($datosActividad[$i]['fecha_inicio']);
				$fechaFin=strtotime($datosActividad[$i]['fecha_termino']);
				$fechaHoy =strtotime($fecha);
			
					if($fechaHoy>$fechaFin){//caso exepcional si la fecha actual es despues de la fecha de termino
						
						$diasTotales = ((strtotime($datosActividad[$i]['fecha_termino'])-strtotime($datosActividad[$i]['fecha_inicio']))/86400);
					    $diasCorridos = $diasTotales;
					  	$esperadoX = ($diasCorridos*100)/$diasTotales;
					}
					else{
						
						if($fechaHoy<$fechaIni){//este es caso exepcional si la fecha actual es antes de la fecha de inicio
								  
						  	$esperadoX = 0;	
							
						}else{//si no es un caso normal

									$diasTotales = ((strtotime($datosActividad[$i]['fecha_termino'])-strtotime($datosActividad[$i]['fecha_inicio']))/86400);
					    			$diasCorridos = ((strtotime($fecha)-strtotime($datosActividad[$i]['fecha_inicio']))/86400);
					  				$esperadoX = ($diasCorridos*100)/$diasTotales;	
							
						}//fin else
					}//fin else
					
					$datosActividad[$i]['esperadoX']=round($esperadoX);
					$datosActividad[$i]['avance_actual']=$datosActividad[$i]['avance_actual'].'-'.$esperadoX;
					$esperadoX = round($esperadoX);
			}else{
				$datosActividad[$i]['esperadoX']='S.I.';
				$datosActividad[$i]['avance_actual']=$datosActividad[$i]['avance_actual'].'-'.'S.I.';
			}
	
	  }//fin for

	
		$dataProvider = new CArrayDataProvider($datosActividad, 
		array(
			   'keyField' => 'id',         
			   'id' => 'data', 
			    'pagination'=>array(
			        'pageSize'=>7,
			    ),                   
			)
			
		);
		
		$this->layout = '//layouts/iframe';
		$this->render('viewIndicador', array(
				'id'=>$idi, 
				'arr'=>$indi,
				'hitos'=>$hitos,
				'meses'=>$meses,
				'dataProvider'=>$dataProvider
				
		));
	}//fin funcion update


public function actionReportes(){
	
	date_default_timezone_set("America/Santiago");
	$mesNombre=date("F");	 
	//cambiando nombre meses
	if ($mesNombre=="January") $mesNombre="enero";
	if ($mesNombre=="February") $mesNombre="febrero";
	if ($mesNombre=="March") $mesNombre="marzo";
	if ($mesNombre=="April") $mesNombre="abril";
	if ($mesNombre=="May") $mesNombre="mayo";
	if ($mesNombre=="June") $mesNombre="junio";
	if ($mesNombre=="July") $mesNombre="julio";
	if ($mesNombre=="August") $mesNombre="agosto";
	if ($mesNombre=="September") $mesNombre="septiembre";
	if ($mesNombre=="October") $mesNombre="octubre";
	if ($mesNombre=="November") $mesNombre="noviembre";
	if ($mesNombre=="December") $mesNombre="diciembre";

	$amis = LineasAccion::model()->busquedaAmiReporte(0);
	$amis = $amis->getData();
	$lineas = LineasAccion::model()->busquedaAmiReporte(1);
	$lineas = $lineas->getData();
	$seguimientoAMI='';
	$detallesAMI='';
	$seguimientoLA='';
	$detallesLA='';
	$datosImprimir = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
	$totalRevisado = 0.0;
	$totalActual = 0.0;
	$totalEsperado = 0.0;
	$totalPonderado = 0.0;
	$totalRevisadoPonderado = 0.0;
	$totalRevisado2 = 0.0;
	$totalActual2 = 0.0;
	$totalEsperado2 = 0.0;
	$totalPonderado2 = 0.0;
	$totalRevisadoPonderado2 = 0.0;
	/**
	 * creando tabla seguimiento AMIS
	 */
	
	$seguimientoAMI='<table height="220" border="1" cellpadding="0" cellspacing="0" align = "center">
		  			 <tr><td colspan="8" bgcolor="#CCCCCC"><center><strong>SEGUIMIENTO AMI</strong></center></td></tr>
		  			 <tr><td bgcolor="#CCCCCC"><strong>Gobierno Regional</strong></td>
		    		 <td colspan="7">&nbsp;Gobierno Regional de Los Lagos</td></tr>
		  			 <tr><td bgcolor="#CCCCCC"><strong>Fecha</strong></td>
		    		 <td colspan="7">&nbsp;'.$_GET['fecha'].'</td></tr>
		  			 <tr><td bgcolor="#CCCCCC"><strong>Responsable</strong></td>
		  			 <td colspan="7">&nbsp;</td></tr>
		  			 <tr><td height="67" colspan="8">    
		    		 <table width="1100" border="1" cellpadding="0" cellspacing="0">
		      		 <tr><td rowspan="2" bgcolor="#CCCCCC"><center>AMI</center></td>
		        	 <td rowspan="2" bgcolor="#CCCCCC"><center><strong>Elemento de Gestión (EG)</strong></center></td>
		        	 <td colspan="3" bgcolor="#CCCCCC"><center><strong>Puntaje</strong></center></td>
		        	 <td rowspan="2" bgcolor="#CCCCCC"><center><strong>Delta Ponderado Esperado</strong></center></td>
		        	 <td rowspan="2" bgcolor="#CCCCCC"><center><strong>Delta Ponderado Validado</strong></center></td></tr>
		     		 <tr><td bgcolor="#CCCCCC"><center><strong>Actual</strong></center></td>
		     		 <td bgcolor="#CCCCCC"><center><strong>Esperado</strong></center></td>
		        	 <td bgcolor="#CCCCCC"><center><strong>Validado</strong></center></td></tr>';
		        
		        for($j=0; $j<count($amis); $j++){
		 
	$seguimientoAMI=$seguimientoAMI.'<tr><td>&nbsp;'.$amis[$j]['nombre'].'</td><td>&nbsp;';

			       	 $elementos = LaElemGestion::model()->elementosGestionPorAmi($amis[$j]['id']);
			       	 
			       	 $criteriosSub = '';
		        	 for($k=0; $k<count($elementos); $k++){
		        	 	
					       if($k==0){
					        		$criteriosSub=$criteriosSub.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					       }else{
					        			
					       		if(($k+1)%3==0){
					        		$criteriosSub=$criteriosSub.';<br/>&nbsp;&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        	}else{
					        		$criteriosSub=$criteriosSub.';&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        	}
					        }
				      }//fin for
	$seguimientoAMI=$seguimientoAMI.$criteriosSub.'</td><td>&nbsp;';        
			       
					 $puntajeActual = '';
				     for($k=0; $k<count($elementos); $k++){
				        		
				        if(!is_null($elementos[$k]['puntaje_actual'])){
					        if($k==0){
					        	$puntajeActual = $elementos[$k]['puntaje_actual'];
					    	}else{
						        if(($k+1)%3==0){
						        	$puntajeActual = $puntajeActual.';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_actual'];
						        }else{
						        	$puntajeActual = $puntajeActual.';&nbsp;'.$elementos[$k]['puntaje_actual'];
						        }
					    	 }
				      		  $totalActual = $totalActual+$elementos[$k]['puntaje_actual'];
				        }//fin fi
				      }//fin for
				    
	$seguimientoAMI=$seguimientoAMI.$puntajeActual.'</td><td>&nbsp;';
					 $puntajeEsperado = '';
					 $puntajeEsperadoArr = array();
					 $puntajeEsperadoArr[0]['puntaje_esperado']=0;
					 $deltaPonderadoEsperado=array();
				     for($k=0; $k<count($elementos); $k++){
				     	$deltaPonderadoEsperado[$k]['esperado']='S.I.';
				     	$puntajeEsperadoArr = LaElemGestion::model()->findAll(array('condition'=>'t.estado = 1 AND t.id_la IS NOT NULL AND t.id_elem_gestion='.$elementos[$k]['idElem'].' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'select'=>'t.puntaje_esperado'));
					    $puntaje_esperado=0;
                        if(isset($puntajeEsperadoArr[0])){
                            $puntaje_esperado=$puntajeEsperadoArr[0]['puntaje_esperado'];
                        }
                            if($k==0){
					        	$puntajeEsperado=$puntaje_esperado;
						    }else{
						        if(($k+1)%3==0){
						        	$puntajeEsperado=$puntajeEsperado.';<br/>&nbsp;&nbsp;'.$puntaje_esperado;
						        }else{
						        	$puntajeEsperado =$puntajeEsperado.';&nbsp;'.$puntaje_esperado;
						        }
						    }
					        	$totalEsperado = $totalEsperado+$puntaje_esperado;
					        $deltaPonderadoEsperado[$k]['esperado'] = ($puntaje_esperado-$elementos[$k]['puntaje_actual'])*$elementos[$k]['puntaje_elemento'];
				       
				    }//fin for
				   
	               $seguimientoAMI=$seguimientoAMI.$puntajeEsperado.'</td><td>&nbsp;';
			       $puntajeRevisado='';
			       $puntajeRevisadoArr=array();
			       $puntajeRevisadoArr[0]['revisado']=0;
			       $deltaPonderadoRevisado = array();
				   for($k=0; $k<count($elementos); $k++){
    				   	$deltaPonderadoRevisado[$k]['revisado']='S.I.';
    				    $puntajeRevisadoArrSQL = LaElemGestion::model()->findAll(array('condition'=>'t.puntaje_revisado IS NOT NULL AND id_la IS NULL AND t.id_elem_gestion='.$elementos[$k]['idElem'].' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'order'=>'t.fecha DESC','select'=>'t.puntaje_revisado'));    
    				   	$puntaje_revisado=0;
                        if(isset($puntajeRevisadoArrSQL[0])){
                            $puntaje_revisado=$puntajeRevisadoArrSQL[0]['puntaje_revisado'];
                        }
					       if($k==0){
					        	$puntajeRevisado= $puntaje_revisado;
					       }else{
						       if(($k+1)%3==0){
						        	$puntajeRevisado=$puntajeRevisado.';<br/>&nbsp;&nbsp;'.$puntaje_revisado;
						       }else{
						        	$puntajeRevisado=$puntajeRevisado.';&nbsp;'.$puntaje_revisado;
						        }
					       }
					        	$totalRevisado = $totalRevisado+$puntaje_revisado;
	
					        	$deltaPonderadoRevisado[$k]['revisado']=($puntaje_revisado-$elementos[$k]['puntaje_actual'])*$elementos[$k]['puntaje_elemento'];
				     }//fin for
	$seguimientoAMI=$seguimientoAMI.$puntajeRevisado.'</td><td>&nbsp;';	   
					 
				     $resultado = 0.0;
				     for($k=0; $k<count($deltaPonderadoEsperado); $k++){
				     	
				     	if($deltaPonderadoEsperado[$k]['esperado']!='S.I.'){
				        	$resultado = $resultado+$deltaPonderadoEsperado[$k]['esperado'];
				     	}
				        		
				     }//fin for
				        $totalPonderado = $totalPonderado+$resultado;
				        
	$seguimientoAMI=$seguimientoAMI.$resultado.'</td><td>&nbsp;';	
			    
					
				    $resultado = 0.0;
				    for($k=0; $k<count($deltaPonderadoRevisado); $k++){ 
				    	if($deltaPonderadoRevisado[$k]['revisado']!='S.I.'){	
				        	$resultado = $resultado+$deltaPonderadoRevisado[$k]['revisado'];   
				    	}  		
				    }//fin for
				      $totalRevisadoPonderado = $totalRevisadoPonderado+$resultado;
				   
	$seguimientoAMI=$seguimientoAMI.$resultado.'</td></tr>';

		        }//fin for
	$seguimientoAMI=$seguimientoAMI.'</td></tr>
		  							<tr><td colspan="2" bgcolor="#CCCCCC"><strong>Sub Total AMI</strong></td>
		    						<td>&nbsp;'.$totalActual.'</td>
		    						<td>&nbsp;'.$totalEsperado.'</td>
		    						<td>&nbsp;'.$totalRevisado.'</td>
		    						<td>&nbsp;'.$totalPonderado.'</td>
		    						<td>&nbsp;'.$totalRevisadoPonderado.'</td>
		    						</tr></table></td></tr></table>';
	
	/*
	 * creando tabla detalles AMIS
	 */
	
	$datosAmi= LineasAccion::model()->unaAmiDetalles(0, 1);
	
	if(isset($datosAmi)&&count($datosAmi)!=0){
		
		for($p=0; $p<count($datosAmi); $p++){
			$indice = '';
		
				$indice = $p+1;
			
			if($p<10){
				$indice =' 0'.$indice; 
			}
				$detallesAMI = $detallesAMI.'<br />'.'<table height="114" border="1" cellpadding="0" cellspacing="0" align="center">
			  								<tr><td height="21" colspan="4" bgcolor="#CCCCCC"><strong><center>SEGUIMIENTO DE ACCIÓN DE MEJORA INMEDIATA'.$indice.'</center></strong></td></tr>
			  								<tr><td  height="21" bgcolor="#CCCCCC"><strong>Gobierno Regional</strong></td>
			    							<td colspan="3">&nbsp; Gobierno Regional de Los Lagos</td></tr>
			 								<tr><td height="21" bgcolor="#CCCCCC"><strong>Acción de Mejora Inmediata</strong></td>
			    							<td colspan="3">&nbsp;'.$datosAmi[$p]['nombre'].' '.$datosAmi[$p]['descripcion'].'</td></tr>
			  								<tr><td height="21" bgcolor="#CCCCCC"><strong>Fecha de Seguimiento</strong></td>
			    							<td >&nbsp;'.$_GET['fecha'].'</td>
			    							<td bgcolor="#CCCCCC"><strong>Encargado de Seguimiento</strong></td>
			    							<td >&nbsp;'.$datosAmi[$p]['r_mantencion'].'</td></tr>
			  								<tr><td colspan="4">
			    							<table border="1" width="1100" cellpadding="0" cellspacing="0" align="center">
			      							<tr><td rowspan="2" bgcolor="#CCCCCC"><center><strong>Actividad</strong></center></td>
			        						<td colspan="2" bgcolor="#CCCCCC"><center><strong>Ejecución</strong></center></td>
			        						<td rowspan="2" bgcolor="#CCCCCC"><center><strong>Indicador</strong></center></td>
			        						<td rowspan="2" bgcolor="#CCCCCC"><center><strong>Meta</strong></center></td>
			        						<td  rowspan="2" bgcolor="#CCCCCC"><center><strong>Resultado Medición</strong></center></td>
			        						<td rowspan="2" bgcolor="#CCCCCC"><center><strong>Nivel de Logro</strong></center></td></tr>
			      							<tr><td bgcolor="#CCCCCC"><center><strong>Inicio</strong></center></td>
			        						<td bgcolor="#CCCCCC"><center><strong>Término</strong></center></td></tr>';
			       
			       	  $actividades = Actividades::model()->actividadesHitos($mesNombre, $datosAmi[$p]['id_indicador']);
				      if(count($actividades->getData())!=0){
				      $totalMonto=0.0;
				      $actividades = $actividades->getData();
				      for($k=0; $k<count($actividades); $k++){ 
				    
				      	if(is_null($actividades[$k]['avance_actual'])){
				      	
							$actividades[$k]['avance_actual']='S.I.';
							$actividades[$k]['value']=$actividades[$k]['avance_actual'];
						}
						if(!is_null($actividades[$k]['fecha_inicio'])&&!is_null($actividades[$k]['fecha_termino'])&&!is_null($_GET['fecha'])){
							
							$fechaIni=strtotime($actividades[$k]['fecha_inicio']);
							$fechaFin=strtotime($actividades[$k]['fecha_termino']);
							$fechaHoy =strtotime($_GET['fecha']);
						
								if($fechaHoy>$fechaFin){//caso exepcional si la fecha actual es despues de la fecha de termino
								
									$diasTotales = ((strtotime($actividades[$k]['fecha_termino'])-strtotime($actividades[$k]['fecha_inicio']))/86400);
								    $diasCorridos = $diasTotales;
								    if($diasTotales!=0){
								  		$esperadoX = ($diasCorridos*100)/$diasTotales;
								    }else{
								    	$esperadoX = ($diasCorridos*100)/1;
								    }
								}
								else{
								
									if($fechaHoy<$fechaIni){//este es caso exepcional si la fecha actual es antes de la fecha de inicio
											  
									  	$esperadoX = 0;	
										
									}else{//si no es un caso normal
								
												$diasTotales = ((strtotime($actividades[$k]['fecha_termino'])-strtotime($actividades[$k]['fecha_inicio']))/86400);
								    			$diasCorridos = ((strtotime($fecha)-strtotime($actividades[$k]['fecha_inicio']))/86400);
								  				if($diasTotales != 0){
								    				$esperadoX = ($diasCorridos*100)/$diasTotales;	
								  				}else{
								  					$esperadoX = ($diasCorridos*100)/1;
								  				}
										
									}//fin else
								}//fin else
								$actividades[$k]['esperadoX']=round($esperadoX);
								$actividades[$k]['value']=$actividades[$k]['avance_actual'];
								$actividades[$k]['avance_actual']=$actividades[$k]['avance_actual'].'-'.$esperadoX;
								
								$esperadoX = round($esperadoX);
						}else{
			
							$actividades[$k]['esperadoX']='S.I.';
							$actividades[$k]['value']=$actividades[$k]['avance_actual'];
							$actividades[$k]['avance_actual']=$actividades[$k]['avance_actual'].'-'.'S.I.';
							
						}
				      	
			$detallesAMI = $detallesAMI.'<tr><td>&nbsp;'.$actividades[$k]['actividad'].'</td>
				        				<td>&nbsp;'.$actividades[$k]['fecha_inicio'].'</td>
				        				<td>&nbsp;'.$actividades[$k]['fecha_termino'].'</td>
				        				<td>&nbsp;</td><td>&nbsp;100%</td>
				        				<td>&nbsp;'.$actividades[$k]['value'].'</td><td>&nbsp;'.$actividades[$k]['value'].'</td></tr>';
			     
				      }//fin for     
				      }else{
			$detallesAMI = $detallesAMI.'<tr><td colspan="8">&nbsp;No se encontraron registros de actividades</td></tr>';
				   
				      }//fin else
			$detallesAMI = $detallesAMI.'</table></td></tr></table>';
			
		}//fin for principal

}//fin if principal

/*
 * creando seguimiento LA
 */

$seguimientoLA = $seguimientoLA.'<table height="220" border="1" cellpadding="0" cellspacing="0" align ="center">
		  			 <tr><td colspan="8" bgcolor="#CCCCCC"><center><strong>SEGUIMIENTO LÍNEAS DE ACCIÓN</strong></center></td></tr>
		  			 <tr><td bgcolor="#CCCCCC"><strong>Gobierno Regional</strong></td>
		    		 <td colspan="7">&nbsp;Gobierno Regional de Los Lagos</td></tr>
		  			 <tr><td bgcolor="#CCCCCC"><strong>Fecha</strong></td>
		    		 <td colspan="7">&nbsp;'.$_GET['fecha'].'</td></tr>
		  			 <tr><td bgcolor="#CCCCCC"><strong>Responsable</strong></td>
		  			 <td colspan="7">&nbsp;</td></tr>
		  			 <tr><td height="67" colspan="8">    
		    		 <table width="1100" border="1" cellpadding="0" cellspacing="0">
		      		 <tr><td rowspan="2" bgcolor="#CCCCCC"><center>AMI</center></td>
		        	 <td rowspan="2" bgcolor="#CCCCCC"><center><strong>Elemento de Gestión (EG)</strong></center></td>
		        	 <td colspan="3" bgcolor="#CCCCCC"><center><strong>Puntaje</strong></center></td>
		        	 <td rowspan="2" bgcolor="#CCCCCC"><center><strong>Delta Ponderado Esperado</strong></center></td>
		        	 <td rowspan="2" bgcolor="#CCCCCC"><center><strong>Delta Ponderado Validado</strong></center></td></tr>
		     		 <tr><td bgcolor="#CCCCCC"><center><strong>Actual</strong></center></td>
		     		 <td bgcolor="#CCCCCC"><center><strong>Esperado</strong></center></td>
		        	 <td bgcolor="#CCCCCC"><center><strong>Validado</strong></center></td></tr>';
		        
		        for($j=0; $j<count($lineas); $j++){
		 
$seguimientoLA=$seguimientoLA.'<tr><td>&nbsp;'.$lineas[$j]['nombre'].'</td><td>&nbsp;';

			       	 $elementos2 = LaElemGestion::model()->elementosGestionPorAmi($lineas[$j]['id']);
			       	 
			       	 $criteriosSub = '';
		        	 for($k=0; $k<count($elementos2); $k++){
		        	 	
					       if($k==0){
					        		$criteriosSub=$criteriosSub.$elementos2[$k]['n_criterios'].'.'.$elementos2[$k]['n_subcriterios'].'.'.$elementos2[$k]['n_elementos'];
					       }else{
					        			
					       		if(($k+1)%3==0){
					        		$criteriosSub=$criteriosSub.';<br/>&nbsp;&nbsp;'.$elementos2[$k]['n_criterios'].'.'.$elementos2[$k]['n_subcriterios'].'.'.$elementos2[$k]['n_elementos'];
					        	}else{
					        		$criteriosSub=$criteriosSub.';&nbsp;'.$elementos2[$k]['n_criterios'].'.'.$elementos2[$k]['n_subcriterios'].'.'.$elementos2[$k]['n_elementos'];
					        	}
					        }
				      }//fin for
$seguimientoLA=$seguimientoLA.$criteriosSub.'</td><td>&nbsp;';        
			       
					 $puntajeActual = '';
				     for($k=0; $k<count($elementos2); $k++){
				        		
				        if(!is_null($elementos2[$k]['puntaje_actual'])){
					        if($k==0){
					        	$puntajeActual = $elementos2[$k]['puntaje_actual'];
					   		}else{
						        if(($k+1)%3==0){
						        	$puntajeActual = $puntajeActual.';<br/>&nbsp;&nbsp;'.$elementos2[$k]['puntaje_actual'];
						        }else{
						        	$puntajeActual = $puntajeActual.';&nbsp;'.$elementos2[$k]['puntaje_actual'];
						        }
					     	}
					        	$totalActual2 = $totalActual2+$elementos2[$k]['puntaje_actual'];   
				        }//fin if
				      }//fin for
				    
$seguimientoLA=$seguimientoLA.$puntajeActual.'</td><td>&nbsp;';
					 $puntajeEsperado = '';
					 $puntajeEsperadoArr2=array();
					 $puntajeEsperadoArr2[0]['esperado']=0;
					 $deltaPonderadoEsperado2=array();
				     for($k=0; $k<count($elementos2); $k++){
				     	$deltaPonderadoEsperado2[$k][]='S.I.';
				     	$puntajeEsperadoArr2 = LaElemGestion::model()->findAll(array('condition'=>'t.estado = 1 AND t.id_la IS NOT NULL AND t.id_elem_gestion='.$elementos2[$k]['idElem'].' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'select'=>'t.puntaje_esperado'));
					    $puntaje_esperado=0;
                        if(isset($puntajeEsperadoArr2[0])){
                            $puntaje_esperado=$puntajeEsperadoArr2[0]['puntaje_esperado'];
                        }
                            if($k==0){
					        	$puntajeEsperado=$puntaje_esperado;
						    }else{
						        if(($k+1)%3==0){
						        	$puntajeEsperado=$puntajeEsperado.';<br/>&nbsp;&nbsp;'.$puntaje_esperado;
						        }else{
						        	$puntajeEsperado =$puntajeEsperado.';&nbsp;'.$puntaje_esperado;
						        }
						    }
					        	$totalEsperado2 = $totalEsperado2+$puntaje_esperado;
					        	$deltaPonderadoEsperado2[0]['esperado'] = ($puntaje_esperado-$elementos2[$k]['puntaje_actual'])*$elementos2[$k]['puntaje_elemento'];
				    }//fin for
				   
$seguimientoLA=$seguimientoLA.$puntajeEsperado.'</td><td>&nbsp;';
	
			       $puntajeRevisado='';
			       $puntajeRevisadoArr2 = array();
			       $puntajeEsperadoArr2[0]['puntaje_revisado']=0;
			       $deltaPonderadoRevisado2=array();
				   for($k=0; $k<count($elementos2); $k++){
				        $deltaPonderadoRevisado2[$k]['revisado']='S.I.';
				        $puntajeRevisadoArr2 = LaElemGestion::model()->findAll(array('condition'=>'t.puntaje_revisado IS NOT NULL AND id_la IS NULL AND t.id_elem_gestion='.$elementos2[$k]['idElem'].' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'order'=>'t.fecha DESC','select'=>'t.puntaje_revisado'));
					     $puntaje_revisado=0;
                        if(isset($puntajeRevisadoArr2[0])){
                            $puntaje_revisado=$puntajeRevisadoArr2[0]['puntaje_revisado'];
                        }
                           if($k==0){
					        	$puntajeRevisado= $puntaje_revisado;
					       }else{
						       if(($k+1)%3==0){
						        	$puntajeRevisado=$puntajeRevisado.';<br/>&nbsp;&nbsp;'.$puntaje_revisado;
						       }else{
						        	$puntajeRevisado=$puntajeRevisado.';&nbsp;'.$puntaje_revisado;
						        }
					      	}
					        	$totalRevisado2 = $totalRevisado2+$puntaje_revisado;
					        	$deltaPonderadoRevisado2[$k]['revisado'] = ($puntaje_revisado - $elementos2[$k]['puntaje_actual'])*$elementos2[$k]['puntaje_elemento'];
				      
				     }//fin for
$seguimientoLA=$seguimientoLA.$puntajeRevisado.'</td><td>&nbsp;';	   
					 
				     $resultado = 0.0;
				     for($k=0; $k<count($deltaPonderadoEsperado2); $k++){
				     	if(isset($deltaPonderadoEsperado2[$k]['esperado'])){
				     	    if($deltaPonderadoEsperado2[$k]['esperado'] != 'S.I.'){
                                $resultado = $resultado+$deltaPonderadoEsperado2[$k]['esperado'];
                            }
				     	}				     	
				        		
				     }//fin for
				        $totalPonderado2 = $totalPonderado2+$resultado;
				        
$seguimientoLA=$seguimientoLA.$resultado.'</td><td>&nbsp;';	
			    
					
				    $resultado = 0.0;
				    for($k=0; $k<count($deltaPonderadoRevisado2); $k++){ 	
				    	if($deltaPonderadoRevisado2[$k]['revisado'] != 'S.I.'){
				        	$resultado = $resultado+$deltaPonderadoRevisado2[$k]['revisado'];
				    	}
				    }//fin for
				      $totalRevisadoPonderado2 = $totalRevisadoPonderado2+$resultado;
				   
$seguimientoLA=$seguimientoLA.$resultado.'</td></tr>';

		        }//fin for
$seguimientoLA=$seguimientoLA.'</td></tr>
		  							<tr><td colspan="2" bgcolor="#CCCCCC"><strong>Sub Total AMI</strong></td>
		    						<td>&nbsp;'.$totalActual2.'</td>
		    						<td>&nbsp;'.$totalEsperado2.'</td>
		    						<td>&nbsp;'.$totalRevisado2.'</td>
		    						<td>&nbsp;'.$totalPonderado2.'</td>
		    						<td>&nbsp;'.$totalRevisadoPonderado2.'</td>
		    						</tr></table></td></tr></table>';

/*
 * creando tablas detalles LA
 */



$datosLA= LineasAccion::model()->unaAmiDetalles(0, 2);
	
	if(isset($datosLA)&&count($datosLA)!=0){
		
		for($p=0; $p<count($datosLA); $p++){
			$indice = '';
			$indice = $p+1;
			if($p<10){
				$indice = ' 0'.$indice;
			}
				$detallesLA = $detallesLA.'<br />'.'<table align="center" height="114" border="1" cellpadding="0" cellspacing="0">
			  								<tr><td height="21" colspan="4" bgcolor="#CCCCCC"><strong><center>SEGUIMIENTO DE LÍNEA DE ACCIÓN'.$indice.'</center></strong></td></tr>
			  								<tr><td  height="21" bgcolor="#CCCCCC"><strong>Gobierno Regional</strong></td>
			    							<td colspan="3">&nbsp; Gobierno Regional de Los Lagos</td></tr>
			 								<tr><td height="21" bgcolor="#CCCCCC"><strong>Acción de Mejora Inmediata</strong></td>
			    							<td colspan="3">&nbsp;'.$datosLA[$p]['nombre'].' '.$datosLA[$p]['descripcion'].'</td></tr>
			  								<tr><td height="21" bgcolor="#CCCCCC"><strong>Fecha de Seguimiento</strong></td>
			    							<td >&nbsp;'.$_GET['fecha'].'</td>
			    							<td bgcolor="#CCCCCC"><strong>Encargado de Seguimiento</strong></td>
			    							<td >&nbsp;'.$datosLA[$p]['r_mantencion'].'</td></tr>
			  								<tr><td colspan="4">
			    							<table border="1" width="1100" cellpadding="0" cellspacing="0" align="center">
			      							<tr><td rowspan="2" bgcolor="#CCCCCC"><center><strong>Actividad</strong></center></td>
			        						<td colspan="2" bgcolor="#CCCCCC"><center><strong>Ejecución</strong></center></td>
			        						<td rowspan="2" bgcolor="#CCCCCC"><center><strong>Indicador</strong></center></td>
			        						<td rowspan="2" bgcolor="#CCCCCC"><center><strong>Meta</strong></center></td>
			        						<td  rowspan="2" bgcolor="#CCCCCC"><center><strong>Resultado Medición</strong></center></td>
			        						<td rowspan="2" bgcolor="#CCCCCC"><center><strong>Nivel de Logro</strong></center></td></tr>
			      							<tr><td bgcolor="#CCCCCC"><center><strong>Inicio</strong></center></td>
			        						<td bgcolor="#CCCCCC"><center><strong>Término</strong></center></td></tr>';
			       
			       	  $actividades = Actividades::model()->actividadesHitos($mesNombre, $datosLA[$p]['id_indicador']);
				      if(count($actividades->getData())!=0){
				      $totalMonto=0.0;
				      $actividades = $actividades->getData();
				      for($k=0; $k<count($actividades); $k++){ 
				    
				      	if(is_null($actividades[$k]['avance_actual'])){
				      	
							$actividades[$k]['avance_actual']='S.I.';
							$actividades[$k]['value']=$actividades[$k]['avance_actual'];
						}
						if(!is_null($actividades[$k]['fecha_inicio'])&&!is_null($actividades[$k]['fecha_termino'])&&!is_null($_GET['fecha'])){
							
							$fechaIni=strtotime($actividades[$k]['fecha_inicio']);
							$fechaFin=strtotime($actividades[$k]['fecha_termino']);
							$fechaHoy =strtotime($_GET['fecha']);
						
								if($fechaHoy>$fechaFin){//caso exepcional si la fecha actual es despues de la fecha de termino
								
									$diasTotales = ((strtotime($actividades[$k]['fecha_termino'])-strtotime($actividades[$k]['fecha_inicio']))/86400);
								    $diasCorridos = $diasTotales;
								    
								    if($diasTotales!=0){
								  		$esperadoX = ($diasCorridos*100)/$diasTotales;
								    }else{
								    	$esperadoX = ($diasCorridos*100)/1;
								    }
								}
								else{
								
									if($fechaHoy<$fechaIni){//este es caso exepcional si la fecha actual es antes de la fecha de inicio
											  
									  	$esperadoX = 0;	
										
									}else{//si no es un caso normal
								
												$diasTotales = ((strtotime($actividades[$k]['fecha_termino'])-strtotime($actividades[$k]['fecha_inicio']))/86400);
								    			$diasCorridos = ((strtotime($fecha)-strtotime($actividades[$k]['fecha_inicio']))/86400);
								    			
								    			if($diasTotales!=0){
								  					$esperadoX = ($diasCorridos*100)/$diasTotales;	
								    			}else{
								    				$esperadoX = ($diasCorridos*100)/1;
								    			}
										
									}//fin else
								}//fin else
								$actividades[$k]['esperadoX']=round($esperadoX);
								$actividades[$k]['value']=$actividades[$k]['avance_actual'];
								$actividades[$k]['avance_actual']=$actividades[$k]['avance_actual'].'-'.$esperadoX;
								
								$esperadoX = round($esperadoX);
						}else{
			
							$actividades[$k]['esperadoX']='S.I.';
							$actividades[$k]['value']=$actividades[$k]['avance_actual'];
							$actividades[$k]['avance_actual']=$actividades[$k]['avance_actual'].'-'.'S.I.';
							
						}
				      	
			$detallesLA = $detallesLA.'<tr><td>&nbsp;'.$actividades[$k]['actividad'].'</td>
				        				<td>&nbsp;'.$actividades[$k]['fecha_inicio'].'</td>
				        				<td>&nbsp;'.$actividades[$k]['fecha_termino'].'</td>
				        				<td>&nbsp;</td><td>&nbsp;100%</td>
				        				<td>&nbsp;'.$actividades[$k]['value'].'</td><td>&nbsp;'.$actividades[$k]['value'].'</td></tr>';
			     
				      }//fin for     
				      }else{
							$detallesLA = $detallesLA.'<tr><td colspan="8">&nbsp;No se encontraron registros de actividades</td></tr>';
				   
				      }//fin else
			$detallesLA = $detallesLA.'</table></td></tr></table>';
			
		}//fin for principal

}//fin if principal
	
	/*
	 * juntando los tablas para imprimirlas
	 */
	$datosImprimir = $datosImprimir.$seguimientoAMI.$detallesAMI.'<br />'.$seguimientoLA.$detallesLA;
	//imprime el pdf
	if(isset($_GET['pdf'])){
			$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
			$mPDF1->WriteHTML($datosImprimir);
			$mPDF1->Output('ReporteAMILA.pdf','D');
	}
	//imprime el word
	if(isset($_GET['doc'])){
			Yii::app()->request->sendFile('ReporteAMILA.doc',$datosImprimir);		
	}
	
	
	
}//fin funcion reportes

public function actionAddComentario() {

		$title = $_GET['titulo'];
		$model = new IndicadoresObservaciones('search');
		$model->unsetAttributes();
		
		if(isset($_GET['IndicadoresObservaciones'])){			
			if($_GET['IndicadoresObservaciones']['bandera']==1){
				$model->attributes=$_GET['IndicadoresObservaciones'];
				
			}else{
				
					$model->setAttributes($_GET['IndicadoresObservaciones']);
					$model->estado = 1;
					$model->fecha = date("y/m/d", time());
					if($_GET['IndicadoresObservaciones']['bandera2']==0){
						$model->save();
						$_GET['IndicadoresObservaciones']['bandera']==1;
					}else{
						$idItem = $_GET['IndicadoresObservaciones']['id'];
						$modelIndicadorObservacion = IndicadoresObservaciones::model()->find(
			         			array('select'=>'*',
			         				  'condition'=>'t.id ="'.$idItem.'"  AND t.estado=1',
			         				)
			         	);
			         	
			         	if($modelIndicadorObservacion != null){
			         		
			         		$modelIndicadorObservacion->observacion = $_GET['IndicadoresObservaciones']['observacion'];
			         		
			         	}
			         	
						$modelIndicadorObservacion->update();
						$_GET['IndicadoresObservaciones']['bandera']==1;
					}
					$model = new IndicadoresObservaciones('search');
					$model->unsetAttributes();
					$model->id_usuario = $_GET['IndicadoresObservaciones']['id_usuario'];
					$model->id_indicador = $_GET['IndicadoresObservaciones']['id_indicador'];
					$model->tipo_observacion = $_GET['IndicadoresObservaciones']['tipo_observacion'];
					
			}
		}
		

		

		$this->layout = '//layouts/iframe';
       	   $this->render('comentario',array(
		        'model'=>$model,
       	   		'title'=>$title
		    ));
	}//fin funcion add comentario

    public function actionObtenerObservacion($id){
    	
    	$model = new IndicadoresObservaciones();
    	$observaciones = $model->buscaObs($id);
    	//$indicadores = Indicadores::indicadoresPorProductoEspecifico($id);
    
		header("Content-type: application/json");
		$json = CJSON::encode($observaciones);
		echo $json;
    	
    }//fin funcion obtener observacion
}
?>