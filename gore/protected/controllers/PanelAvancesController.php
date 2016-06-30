<?php
include dirname(Yii::app()->request->scriptFile).'/protected/views/panelAvances/ConsultasView.php';

class PanelAvancesController extends GxController {

    public function filters() {
    return array(
            'accessControl', 
            );
    }
    
    public function accessRules() {                  
          return array(
            array('allow',
                'actions'=>array('index','borrar','view','admin','verComentarios','excel','indicadoresCentroResponsabilidad','registroavance','registroavanceview', 'productosEstrategicosApoyo', 'indicadoresInstrumentos', 'indicadoresCentroResponsabilidad'),    
            	'roles'=>array('gestor','finanzas','supervisor','supervisor2'),            
               // 'users'=>array('@'),//Solo usuarios autentificados
            ),
            array('allow',
                'actions'=>array('update','borrar','registroavance'), //'minicreate', 'create', 'update', 'admin', 'delete'
                //Si necesitamos agregar un rol diferente a admin, debemos ir a modificar la función checkAccessChange
                'expression'=>"(Yii::app()->user->checkAccessChange(array('modelName'=>'Indicadores','fieldName'=>'responsable_id','idRow'=>Yii::app()->getRequest()->getQuery('idi'))))||(Yii::app()->user->checkAccessChange(array('modelName'=>'HitosIndicadores','fieldName'=>'idIndicador->responsable_id','idRow'=>Yii::app()->getRequest()->getQuery('id'))))",            
            ),             
            array('deny',
                'users'=>array('*'),
            ),
        );
    }  

  public function actionProductosEstrategicosApoyo(){
    	
    	?>
    	      <div id="contenedorControl1" class="contenedorControl">
		        
		        <p><h2>Estado General de Avances:</h2></p>
			        <letraSubTitulos>Productos Estratégicos del Apoyo</letraSubTitulos></p>
    						<?php
    						$productoEstrategicoA=Indicadores::model()->buscarProductoEstrategicoIndicadores(2, 0);
							
						
							if(empty($productoEstrategicoA)){
								echo ' No se encontraron registros';
								
							}else{
							
								$arreglo2 = array();
								
								$c= new ConsultasView;
								
								$arreglo2=$c->recorreResultado($productoEstrategicoA, 'id_pro_estrategico', 'producto_estrategico_n', 'P');
								
								if(empty($arreglo2)){
									
									
								}else{
									
								
									for($i=0; $i<count($arreglo2);$i++){
											$idp=$arreglo2[$i]['id'];
											$content=$arreglo2[$i]['c'];
											$nom= $arreglo2[$i]['nom'];
										
										if(empty($idp)||empty($content)||empty($nom)){
											
										}else{
										
											echo '<a class="update" href="'.Yii::app()->request->baseUrl.'/panelAvances/view?id='.$idp.'&nombreP='.$nom.'&b=1&title=Avance Producto Estratégico">'.$content.'</a>';
										}
									}//fin for
							
								}
								
							}
							
							?>
							</div>
							<?php 
 
    }
    
    public function actionIndicadoresInstrumentos(){
    	
    	
    	?>
    	<div id="contenedorControl1" class="contenedorControl">
    	<p><h2>Estado General de Avances:</h2></p>
			        <letraSubTitulos>Indicadores por Instrumento</letraSubTitulos></p>
    	<?php 
    					$indicadoresInstrumentos = Instrumentos::model()->indicadoresPorInstrumentos(0);

			  		
			  			if(empty($indicadoresInstrumentos)){
								echo ' No se encontraron registros';
								
							}else{
							
								$arreglo4 = array();
								
								$c= new ConsultasView;
								
								$arreglo4=$c->recorreResultado($indicadoresInstrumentos, 'id_instrumento', 'instrumentoNombre', 'I');
							
								if(empty($arreglo4)){
									
									
								}else{
									
								
									for($i=0; $i<count($arreglo4);$i++){
											$idp=$arreglo4[$i]['id'];
											$content=$arreglo4[$i]['c'];
											$nom= $arreglo4[$i]['nom'];
										
										if(empty($idp)||empty($content)||empty($nom)){
											
										}else{
										
											echo '<a class="update" title="Modificar" href="'.Yii::app()->request->baseUrl.'/panelAvances/view?id='.$idp.'&nombreP='.$nom.'&b=2&title=Indicadores Instrumento">'.$content.'</a>';
										}
									}//fin for
							
								}
								
							}
							?>
							</div>
							<?php 
    	
    }
    
    public function actionIndicadoresCentroResponsabilidad(){
    		       		
    	
    	?>
    	<div id="contenedorControl1" class="contenedorControl">
    	<p><h2>Estado General de Avances:</h2></p>
			        <letraSubTitulos>Indicadores por Centro de Responsabilidad</letraSubTitulos></p>
    	<?php
    					$indicadoresDivisiones=Indicadores::model()->indicadoresDivision(0);
							if(empty($indicadoresDivisiones)){
								echo ' No se encontraron registros';
								
							}else{
							
								$arreglo3 = array();
								
								$c= new ConsultasView;
								
								$arreglo3=$c->recorreResultado($indicadoresDivisiones, 'division_id', 'division', 'C');
								
								if(empty($arreglo3)){
									
									
								}else{
									
								
									for($i=0; $i<count($arreglo3);$i++){
											$idp=$arreglo3[$i]['id'];
											$content=$arreglo3[$i]['c'];
											$nom= $arreglo3[$i]['nom'];
										
										if(empty($idp)||empty($content)||empty($nom)){
											
										}else{
										
											echo '<a class="update" href="'.Yii::app()->request->baseUrl.'/panelAvances/view?id='.$idp.'&nombreP='.$nom.'&b=3&title=Indicadores Centro de Responsabilidad">'.$content.'</a>';
										}
									}//fin for
							
								}
								
							}
							
							?>
							</div>
							<?php 
    	
    }
	public function actionView($id, $nombreP, $b, $title) {

	
		$indi = array();
		if($b==1){
			$indi= Indicadores::model()->buscarProductoEstrategicoIndicadores($id, 1);
		}
		if($b==3){
			$indi = Indicadores::model()->indicadoresDivision($id);
		}
		
		if($b==2){
			$indi = Instrumentos::model()->indicadoresPorInstrumentos($id);
		}
		
	//	print_r($indi);
		if(!empty($indi)){
		
		for ($i=0; $i<count($indi);$i++){
			$auxiliar=array();
			$c = new ConsultasView();
		
		
			if(!empty($indi[$i]['id'])&&$indi[$i]['plazo_maximo']){
				//echo 'entro a for';
				
				if (isset($indi[$i]['responsable_id'])){
					$indi[$i]['nombreResponsable']= IndicadoresController::obtenerNombreUsuario($indi[$i]['responsable_id']);
				}else{
					$indi[$i]['nombreResponsable'] = "-";
				}
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

				 if(!empty($indi[$i]['frecuenciaControl'])){
					 $indi[$i]['frecuencia'] = $indi[$i]['frecuenciaControl'];
				 }else{
				 	$indi[$i]['frecuencia'] = 'S.I.';
				 }
				 
				 if($indi[$i]['ascendente']==1){//indicadore es ascendente
				 	
				 	$indi[$i]['value']=$indi[$i]['value'].' '.$indi[$i]['ascendente'].' '.$indi[$i]['esperado'];
				 	$indi[$i]['ascendente1']= 'Ascendente';
				 	
				 }else{//sino descendente
				 	if($indi[$i]['ascendente']==0){
					 	$indi[$i]['value']=$indi[$i]['value'].' '.$indi[$i]['ascendente'].' '.$indi[$i]['esperado'];
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
				 if(!empty($indi[$i]['frecuenciaControl'])){
					 $indi[$i]['frecuencia'] = $indi[$i]['frecuenciaControl'];
				 }else{
				 	$indi[$i]['frecuencia'] = 'S.I.';
				 }
				 if($indi[$i]['ascendente']==1){//indicadore es ascendente
				 	
				 	$indi[$i]['value']=$indi[$i]['value'].' '.$indi[$i]['ascendente'].' '.$indi[$i]['esperado'];
				 	$indi[$i]['ascendente1']= 'Ascendente';
				 	
				 	
				 }else{//sino descendente
				 	if($indi[$i]['ascendente']==0){
					 	$indi[$i]['value']=$indi[$i]['value'].' '.$indi[$i]['ascendente'].' '.$indi[$i]['esperado'];
					 	$indi[$i]['ascendente1']= 'Descendente';
				 	}
				}
		
			}
			
		}//fin for
		}
		
	
		$dataProvider = new CArrayDataProvider($indi, 
		array(
			   'keyField' => 'id',         
			   'id' => 'data', 
			    'pagination'=>array(
			        'pageSize'=>7,
			    ),                   
			)
			
		);
		
		$this->layout = '//layouts/iframe';
       	$this->render('view', array(
                'nombre'=>$nombreP,
       			'id'=>$id, 'dataProvider'=>$dataProvider,
       			'title'=>$title
     
        ));
	}
	
	

	public function actionUpdate($idi) {
		date_default_timezone_set("America/Santiago");

	    $anio = date("Y");
	    $mesNombre=date("F");
	    $dia = date("d");
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
        
        /*
         $tipoFrecuencia=$model->indicador->frecuencia_control_id;
                 $arrayMensual=array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
                 if($tipoFrecuencia==2){
                     //el array debe ser trimestral
                     $arrayMensual=Array("marzo","junio","septiembre","diciembre");
                 }
         */
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
		
        $mesNombreActual="";  
        if(isset($hitos[0])){
            $frecuenciaControl = $hitos[0]->idIndicador->frecuencia_control_id;              
            $arrayMensual=array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
            if($frecuenciaControl==2){
                 //el array debe ser trimestral
                 $arrayMensual=Array("marzo","junio","septiembre","diciembre");
            }
            if (in_array($mesNombre, $arrayMensual)) {
                $mesNombreActual=$mesNombre;
            }else if($frecuenciaControl==2){
                if($mesNombre=="abril"|| $mesNombre=="mayo"){
                    $mesNombreActual="marzo";
                }else if($mesNombre=="julio"|| $mesNombre=="agosto"){
                    $mesNombreActual="junio";
                }else if($mesNombre=="octubre"|| $mesNombre=="noviembre"){
                    $mesNombreActual="septiembre";
                }else{
                    $mesNombreActual=$mesNombre;
                }
            }else{
                $mesNombreActual=$mesNombre;
            }
        }else{
            $mesNombreActual=$mesNombre;
        }           
        
		//trayendo los datos de actividades
		$datosActividad = Actividades::model()->actividadesHitos($mesNombreActual,$idi);
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
					    if($diasTotales != 0){
					  		$esperadoX = ($diasCorridos*100)/$diasTotales;
					    }else{
					    	$esperadoX = ($diasCorridos*100)/1;
					    }
					}
					else{
						
						if($fechaHoy<$fechaIni){//este es caso exepcional si la fecha actual es antes de la fecha de inicio
								  
						  	$esperadoX = 0;	
							
						}else{//si no es un caso normal

									$diasTotales = ((strtotime($datosActividad[$i]['fecha_termino'])-strtotime($datosActividad[$i]['fecha_inicio']))/86400);
					    			$diasCorridos = ((strtotime($fecha)-strtotime($datosActividad[$i]['fecha_inicio']))/86400);
					  				
					    			if($diasTotales!=0){
					    				$esperadoX = ($diasCorridos*100)/$diasTotales;	
					    			}else{
					    				
					    				$esperadoX = ($diasCorridos*100)/1;
					    			}
							
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
		
		$this->render('viewIndicador', array(
				'id'=>$idi, 
				'arr'=>$indi,
				'hitos'=>$hitos,
				'meses'=>$meses,
				'dataProvider'=>$dataProvider
				
		));
        
	}


	
/********************************************************************
 * actionRegistroavance
 * ====================
 * 
 ********************************************************************/
	public function actionRegistroavance($id){
		
		//$modelActividades = Actividades::model()->findAll(array('condition'=>'indicador_id='.$id.' AND estado= 1'));

        
        
        $modelHitos = HitosIndicadores::model()->find(array('condition'=>'id='.$id.' AND estado= 1'));
        
        
        $model = new CActiveDataProvider('Actividades',
            array(
            'criteria' => array(
                'select'=>'t.*, hi.avance_actual as avanceActual, hi.id as idHito, hi.actividad_mes as mesActual',
                'join'     =>'INNER JOIN hitos_actividades hi on t.id = hi.id_actividad',   
                'condition'=>'t.estado=1 AND indicador_id='.$modelHitos->id_indicador.' AND hi.actividad_mes ="'.$modelHitos->mes.'"',
            )
            
        ));
        
        
        $modelIndicadores=Indicadores::model()->find(
                        array('select'=>'t.*, tf.formula as tipos_formulas_formula',
                              'join'=>'INNER JOIN tipos_formulas tf on tf.id=t.tipo_formula_id',
                              'condition'=>'t.id='.$modelHitos->id_indicador.'  AND t.estado=1 ',
                            )
                        );
                        
        $frecuenciaControl = $modelIndicadores->frecuenciaControl;              
        
        if (isset($_POST['avance'])) {
            
            $formAvance = $_POST['avance'];
            
            //print_r($formAvance);

            //print_r($_FILES['avance']['name']['documentoIndicador']);
            
            //print_r($_FILES['avance']);
    
            $form_calculo = substr($formAvance['calculo'] , 0, -1); // extrae %
            
            
            
           // $modelHitos->documentoIndicador=$_FILES['avance']['name']['documentoIndicador'];
            $modelHitos->documentoActividad=$_FILES['avance']['name']['documentoActividad'];
            
            if(!empty($modelHitos->documentoIndicador) )
            {
                $nombrePDF = PanelAvancesController::concatenarnombre($modelHitos->documentoIndicador);//Limpia el nombre de archivo y ademas de concatena la fecha
                
                $modelHitos->evidencia = $nombrePDF;
                
                move_uploaded_file($_FILES['avance']['tmp_name']['documentoIndicador'],Yii::getPathOfAlias('webroot').'/upload/doc/'.''.$nombrePDF);
                
            }
            
            if(!empty($modelHitos->documentoActividad) )
            {
                $nombrePDF = PanelAvancesController::concatenarnombre($modelHitos->documentoActividad);//Limpia el nombre de archivo y ademas de concatena la fecha
                
                $modelHitos->evidencia_actividad = $nombrePDF;
                
                move_uploaded_file($_FILES['avance']['tmp_name']['documentoActividad'],Yii::getPathOfAlias('webroot').'/upload/doc/'.''.$nombrePDF);
                
            }
            
            
            //Update Hitos_Indicadores
            $modelHitos->meta_reportada= $form_calculo;
            $modelHitos->conceptoa= $formAvance['valorA'];
            $modelHitos->conceptob= $formAvance['valorB'];
            $modelHitos->conceptoc= $formAvance['valorC'];
            $modelHitos->update();
        
            $formActividades = $_POST['actividades'];
            $countActividades = count($formActividades);
            //echo $countActividades;
            if ($countActividades > 1){
                if (isset($formActividades)) {
                    //print_r($formActividades);    
                    
                    foreach ($formActividades as $idActividad => $val) {
                        //Por defecto trae un input con un id 0
                        if ($idActividad != 0){
                            //$modelActividad=Actividades::model()->find('id='.$idActividad);
                            $modelActividad=HitosActividades::model()->find('id='.$idActividad);
                            
                            if($modelActividad->avance_actual != $val){
                                //$modelActividad->avance_anterior=  $modelActividad->avance_actual;
                                $modelActividad->avance_actual = $val;
                                $modelActividad->update();
                            }
                        }
                    }   
                }
            }
            //echo CHtml::script("parent.cerrarModal();");
            echo CHtml::script("parent.location.reload();");
            Yii::app()->end();
            
            
        }//END-POST
    
        $this->layout = '//layouts/iframe'; 
        $this->render('registroavance', array(
            'model' => $model,
            'modelHitos' => $modelHitos,
            'modelindicadores'=>$modelIndicadores,
            'nombre_i'=>$_GET['nombre_i'],
            'nombre_productoEst'=>$_GET['nombre_productoEst'],
            'nombre_productoEsp'=>$_GET['nombre_productoEsp'],
            'nombre_sub'=>$_GET['nombre_sub'],
            'frecuenciaControl'=>$frecuenciaControl,
        )); 
        
	}
	
/********************************************************************
 * actionRegistroavanceView
 * ====================
 * 
 ********************************************************************/
	public function actionRegistroavanceview($id){
		
		//$modelActividades = Actividades::model()->findAll(array('condition'=>'indicador_id='.$id.' AND estado= 1'));

        
		
		$modelHitos = HitosIndicadores::model()->find(array('condition'=>'id='.$id.' AND estado= 1'));
		
		
		$model = new CActiveDataProvider('Actividades',array(
            'criteria' => array('condition'=>'estado=1 AND indicador_id='.$modelHitos->id_indicador,)
        ));
        
		$modelIndicadores=Indicadores::model()->find(
	         			array('select'=>'t.*, tf.formula as tipos_formulas_formula',
	         				  'join'=>'INNER JOIN tipos_formulas tf on tf.id=t.tipo_formula_id',
	         				  'condition'=>'t.id='.$modelHitos->id_indicador.'  AND t.estado=1',
	         				)
	         			);
	         			
		$frecuenciaControl = $modelIndicadores->frecuenciaControl;  
		if (isset($_POST['avance'])) {
			
			$formAvance = $_POST['avance'];
			
			//print_r($formAvance);

			//print_r($_FILES['avance']['name']['documentoIndicador']);
			
			//print_r($_FILES['avance']);
	
			$form_calculo = substr($formAvance['calculo'] , 0, -1); // extrae %
			
			
			
			$modelHitos->documentoIndicador=$_FILES['avance']['name']['documentoIndicador'];
			$modelHitos->documentoActividad=$_FILES['avance']['name']['documentoActividad'];
			
			if(!empty($modelHitos->documentoIndicador) )
			{
				$nombrePDF = PanelAvancesController::concatenarnombre($modelHitos->documentoIndicador);//Limpia el nombre de archivo y ademas de concatena la fecha
				
				$modelHitos->evidencia = $nombrePDF;
				
				move_uploaded_file($_FILES['avance']['tmp_name']['documentoIndicador'],Yii::getPathOfAlias('webroot').'/upload/doc/'.''.$nombrePDF);
				
			}
			
			if(!empty($modelHitos->documentoActividad) )
			{
				$nombrePDF = PanelAvancesController::concatenarnombre($modelHitos->documentoActividad);//Limpia el nombre de archivo y ademas de concatena la fecha
				
				$modelHitos->evidencia_actividad = $nombrePDF;
				
				move_uploaded_file($_FILES['avance']['tmp_name']['documentoActividad'],Yii::getPathOfAlias('webroot').'/upload/doc/'.''.$nombrePDF);
				
			}
			
			
			//Update Hitos_Indicadores
			$modelHitos->meta_reportada= $form_calculo;
			$modelHitos->conceptoa= $formAvance['valorA'];
			$modelHitos->conceptob= $formAvance['valorB'];
			$modelHitos->conceptoc= $formAvance['valorC'];
			$modelHitos->update();
		
			$formActividades = $_POST['actividades'];
			$countActividades = count($formActividades);
			//echo $countActividades;
			if ($countActividades > 1){
				if (isset($formActividades)) {
					//print_r($formActividades);	
					
					foreach ($formActividades as $idActividad => $val) {
						//Por defecto trae un input con un id 0
						if ($idActividad != 0){
							$modelActividad=Actividades::model()->find('id='.$idActividad);
				        	
							if($modelActividad->avance_actual != $val){
								$modelActividad->avance_anterior=  $modelActividad->avance_actual;
								$modelActividad->avance_actual = $val;
								$modelActividad->update();
							}
						}
					}	
				}
			}
			//echo CHtml::script("parent.cerrarModal();");
			echo CHtml::script("parent.location.reload();");
			Yii::app()->end();
			
			
		}//END-POST
	
		$this->layout = '//layouts/iframe'; 
        $this->render('registroavanceView', array(
        	'model' => $model,
        	'modelHitos' => $modelHitos,
        	'modelindicadores'=>$modelIndicadores,
        	'nombre_i'=>$_GET['nombre_i'],
        	'nombre_productoEst'=>$_GET['nombre_productoEst'],
        	'nombre_productoEsp'=>$_GET['nombre_productoEsp'],
       		'nombre_sub'=>$_GET['nombre_sub'],
        	'frecuenciaControl'=>$frecuenciaControl,	
        )); 
        
	}
	
	public function actionIndex() {
     
		$this->render('index');
	}
    
public function actionAdmin(){
		$indi = array();
		$indi=Indicadores::indicadorUnUsuario(0);
	if(!empty($indi)){
		
		for ($i=0; $i<count($indi);$i++){
			$auxiliar=array();
			$c = new ConsultasView();
		    
			
			if(!empty($indi[$i]['id'])&&$indi[$i]['plazo_maximo']){
				//echo 'entro a for';
				$sqlIndicador=IndicadoresObservaciones::model()->findAll(array('condition'=>'id_indicador='.$indi[$i]['id']));
                if(isset($sqlIndicador[0])){
                    $indi[$i]['observaciones'] = 'true';
                }
			    
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
				 	
				 	$indi[$i]['value']=$indi[$i]['value'].' '.$indi[$i]['ascendente'].' '.$indi[$i]['esperado'];
				 	$indi[$i]['ascendente1']= 'Ascendente';
				 	
				 }else{//sino descendente
				 	if($indi[$i]['ascendente']==0){
					 	$indi[$i]['value']=$indi[$i]['value'].' '.$indi[$i]['ascendente'].' '.$indi[$i]['esperado'];
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
				 	
				 	$indi[$i]['value']=$indi[$i]['value'].' '.$indi[$i]['ascendente'].' '.$indi[$i]['esperado'];
				 	$indi[$i]['ascendente1']= 'Ascendente';
				 	
				 }else{//sino descendente
				 	if($indi[$i]['ascendente']==0){
					 	$indi[$i]['value']=$indi[$i]['value'].' '.$indi[$i]['ascendente'].' '.$indi[$i]['esperado'];
					 	$indi[$i]['ascendente1']= 'Descendente';
				 	}
				}
			//}//fin for
			}
	
		}//fin for
		}
		
		
		$dataProvider = new CArrayDataProvider($indi, 
			array(
				   'keyField' => 'id',         
				   'id' => 'data',
					'pagination'=>array(
        				'pageSize'=>7,
    				),                    
				)
		);

	
       	$this->render('admin', array(
           
       			'dataProvider'=>$dataProvider
       			
     
        ));
	}
    public function concatenarnombre($nombre){
    	$nombrePDF = "";
       	$nombrePDF = str_replace(' ', '_', $nombre);
		$nombrePDF = date("Y_m_d_H:i:s").$nombrePDF;
		$textoLimpio = preg_replace('([^A-Za-z0-9._])', '', $nombrePDF);
		$nombrePDF = $textoLimpio; 
           
       return $nombrePDF;
    }
    
    protected function validateAccess(){
        $owner_id='';
           //Si viene el idIndicador es porque estamos actualizando o eliminando una actividad de un indicador
           if(Yii::app()->user->checkAccess("admin")){
               $owner_id=TRUE;
           }else{
               if(isset($_GET['idIndicador'])){
                   $model = Indicadores::model()->findAll(array('condition'=>'t.id='.$_GET['idIndicador']));
                   $userID = Yii::app()->user->id;
                   if(isset($model[0]->responsable_id)){
                       $owner_id=$model[0]->responsable_id;
                   } 
                   //Verificando si el usuario tiene permisos para acceder o si es admin     
                   $owner_id=($userID === $owner_id);               
                }
           }
           
       return $owner_id;
    }
    
     public static function validateAccessbyIndicador($idIndicador=0){
       $owner_id=FALSE;     
       if(Yii::app()->user->checkAccess("admin")){
           $owner_id=TRUE;
       }else{
           $model = Indicadores::model()->findAll(array('condition'=>'t.id='.$idIndicador));
           $userID = Yii::app()->user->id;
           if(isset($model[0]->responsable_id)){
               $owner_id=$model[0]->responsable_id;
           } 
           //Verificando si el usuario tiene permisos para acceder o si es admin     
           $owner_id=(($userID === $owner_id));
       }     
       
       return $owner_id;
    }
    
	public function actionExcel($id) {
		
		$data=Actividades::model()->findALL(
	         array('select'=>'t.*',
	         	'condition'=>'t.indicador_id='.$id.'  AND t.estado=1',
	         )
	      );

       	       	
        $phpExcelPath = Yii::getPathOfAlias('application.vendors');
		spl_autoload_unregister(array('YiiBase','autoload'));
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
		
 		// creamos un OBJETO de la clase PHPExcel():
        $objPHPExcel = new PHPExcel();

        $styleCuerpoUnion =
			 array('font' => 
			 array('bold' => true,),
			 'alignment' => 
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			 'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),)
			 ,'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'rotation' => 90,),);
        
        
        $styleArray =
			 array('font' => 
			 array('bold' => true,),
			 'alignment' => 
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			 'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),)
			 ,'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'color' => array('rgb'=>'E1E0F7'),'rotation' => 90,
			 'startcolor' => array('argb' => 'FFA0A0A0',),'endcolor' => array('argb' => 'FFFFFFFF',),),);

		 //stylo solo fuente negrita
		$fuenteNegrita = array(
		    'font' => array(
		        'bold' => true
		    )
		);
        
		
        //style bordes de tabla
		$default_border = array(
		    'style' => PHPExcel_Style_Border::BORDER_THIN,
		    'color' => array('rgb'=>'1006A3')
		);
		
		//style para cabecera de tabla
		$style_header = array(
		    'borders' => array(
		        'bottom' => $default_border,
		        'left' => $default_border,
		        'top' => $default_border,
		        'right' => $default_border,
		    ),
		    'fill' => array(
		        'type' => PHPExcel_Style_Fill::FILL_SOLID,
		        'color' => array('rgb'=>'E1E0F7'),
		    ),
		    'font' => array(
		        'bold' => true,
		    )
		);
		//style cuerpo de tabla
		$style_cuerpo = array(
		    'borders' => array(
		        'bottom' => $default_border,
		        'left' => $default_border,
		        'top' => $default_border,
		        'right' => $default_border,
		    )
		);
		
        
        
        
		//Agregando Ancho
    	$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(4);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(40);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(10);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(10);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(15);

    	
    	//Cambiando estilo del header
    	$objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray(array("font" => array( "bold" => true, "size" => '15')));
		//$objPHPExcel->getActiveSheet()->getStyle("A2:M2")->applyFromArray(array("font" => array( "bold" => true, "center" => true)));
    	//dando style a cabeceras de tabla
		$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($style_header);
    	
		//Colorear Celdas
    	//$objPHPExcel->getActiveSheet()->getStyle("A2:M2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	//$objPHPExcel->getActiveSheet()->getStyle("A2:M2")->getFill()->getStartColor()->setRGB('C0C0C0');

    	//Union de dos celdas
        $objPHPExcel->getActiveSheet()->mergeCells("A1:F1");
        $objPHPExcel->getActiveSheet()->setCellValue('A1','Registro de Avance');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);

        
		//Asignamos los titulos
		$objPHPExcel->getActiveSheet()->setCellValue('A2','Nº');
        $objPHPExcel->getActiveSheet()->setCellValue('B2','Actividades Asociadas');
        $objPHPExcel->getActiveSheet()->setCellValue('C2','Inicio');
        $objPHPExcel->getActiveSheet()->setCellValue('D2','Término');
        $objPHPExcel->getActiveSheet()->setCellValue('E2','Avance Anterior');
        $objPHPExcel->getActiveSheet()->setCellValue('F2','Avance Actual');

     	
        
		$i=3; //Contador de celdas
		$numero=1;//Numero de items
 		foreach($data as $record){
 			//dando style a cada una de las celdas
 		    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray( $style_cuerpo );
 		    $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray( $style_cuerpo );
 		    $objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray( $style_cuerpo );
 		    $objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray( $style_cuerpo );
 		    $objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray( $style_cuerpo );
 		    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray( $style_cuerpo );

 		    
 		     //imprimiendo valores
 			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i ,$numero);
 	        $objPHPExcel->getActiveSheet()->setCellValue('B'.$i ,$record->nombre);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i ,$record->fecha_inicio);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i ,$record->fecha_termino);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i ,$record->avance_anterior);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i ,$record->avance_actual);


                                                                                                                                                
            $i++;//Aumentar celda
            $numero++;//Aumentar numero de items
        }
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="RegistroDeAvance.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        
      
       
	}//fin function
	
	public function actionVerComentarios($id_indicador){
	
		//$id_usuario = Yii::app()->user->id;
		$model = new IndicadoresObservaciones('search');
		$model->unsetAttributes();
		
		$model->id_indicador = $id_indicador;
		//$model->id_usuario = $id_usuario;

		   $this->layout = '//layouts/iframe';
       	   $this->render('comentario',array(
		        'model'=>$model
		    ));
	
	}//fin ver coments
	
	public function actionBorrar($id){
		$campo = $_GET["campo"];
		//$id = $_GET["id"];
		
		$model = $this->loadModel($id, 'HitosIndicadores');
		$resultado = false;
		
		
		
		if ($campo=='evidencia'){
			$documento = Yii::getPathOfAlias('webroot').'/upload/doc/'.$model->evidencia;
			//Eliminando Archivo 
			if(file_exists($documento)){
				unlink($documento);
				$model->evidencia = "";
				$resultado = true;
			} 
			
		
		}
		if($campo=='evidencia_actividad'){
			//echo "evidencia_actividad---";
			$documento = Yii::getPathOfAlias('webroot').'/upload/doc/'.$model->evidencia_actividad;
			//echo $documento."---";
			//Eliminando Archivo 
			if(file_exists($documento)){
				//echo "Archivo Encontrado";
				unlink($documento);
				$model->evidencia_actividad = "";
				$resultado = true;
			} 
		}
		
		if($resultado){
			$model->update();
		}
		

		
		
		
		header("Content-type: application/json");	
		echo CJSON::encode($resultado);
	}
	
    public static function gridDataBreakText($data) {
    
        $string =  $data;
    
        $phrase_array = explode(' ',$data);
    
        if(count($phrase_array) > 20 ){
                if(strlen($string) > 80) { 
                    $string = substr($string, 0, 75);
                    if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
                    return $string . '...';
                }
        }
        return $string;
    }


}