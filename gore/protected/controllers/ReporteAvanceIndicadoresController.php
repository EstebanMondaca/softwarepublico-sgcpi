<?php
include dirname(Yii::app()->request->scriptFile).'/protected/views/panelAvances/ConsultasView.php';
class ReporteAvanceIndicadoresController extends GxController {

    public function filters() {
    return array(
            'accessControl', 
            );
    }
    
    public function accessRules(){                  
          return array(
            array('allow',
               	'actions'=>array('registroavanceview','index','create', 'update', 'obtenerCentrosCostos', 'obtenerGestores', 'obtenerProductosEstrategicos', 'obtenerSubproductos', 'obtenerProductoEspecifico', 'obtenerIndicadoresFiltrados'),    
            	'roles'=>array('gestor','finanzas','supervisor','supervisor2'),   
            ),
            array('allow',
               	'actions'=>array('view', 'obtenerObservacion'),
            	//'expression'=>Yii::app()->user->checkAccess("supervisor2").' && '.Yii::app()->user->checkAccessChangeByCentroCostoFromIndicadores(array('modelName'=>'Indicadores','fieldName'=>'productoEspecifico[0]->subproducto->centro_costo_id','idRow'=>Yii::app()->getRequest()->getQuery("id_indicador"))),
                'expression'=>'Yii::app()->user->checkAccess("supervisor2") && (Yii::app()->user->checkAccessChangeByCentroCostoFromIndicadores(array("modelName"=>"Indicadores","fieldName"=>"productoEspecifico->subproducto->centro_costo_id","idRow"=>'.Yii::app()->getRequest()->getQuery("id_indicador").')) || Yii::app()->user->checkAccessChangeByCentroCostoFromIndicadores(array("modelName"=>"Indicadores","fieldName"=>"lineasAccions[0]->centro_costo_id","idRow"=>'.Yii::app()->getRequest()->getQuery("id_indicador").')))',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    } 
    
	//funcion para agregar o editar un nuevo comentario
	public function actionView() {

		$model = new IndicadoresObservaciones('search');
		$model->unsetAttributes();
		
		if(isset($_GET['IndicadoresObservaciones'])){			
			if($_GET['IndicadoresObservaciones']['bandera']==1){
				$model->attributes=$_GET['IndicadoresObservaciones'];
				$model->id_usuario = Yii::app()->user->id;
			}else{
				
					$model->setAttributes($_GET['IndicadoresObservaciones']);
					$model->estado = 1;
					$model->tipo_observacion = 1;
					$model->fecha = date("y/m/d", time());
					if($_GET['IndicadoresObservaciones']['bandera2']==0){
						$model->save();
						$_GET['IndicadoresObservaciones']['bandera']==1;
					}else{
						$idItem = $_GET['IndicadoresObservaciones']['id'];
						$modelIndicadorObservacion = IndicadoresObservaciones::model()->find(
			         			array('select'=>'*',
			         				  'condition'=>'t.id ="'.$idItem.'"  AND t.estado=1 AND t.tipo_observacion=1',
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
					$model->id_usuario = Yii::app()->user->id;
					$model->id_indicador = $_GET['IndicadoresObservaciones']['id_indicador'];
			}
		}
		

		

		$this->layout = '//layouts/iframe';
       	   $this->render('comentario',array(
		        'model'=>$model
		    ));
	}
	
	

	//funcion que genera un excel
	public function actionCreate() {
	
		 $model=new Indicadores('buscquedaAtributosModelos');
		 $model->unsetAttributes();
		if(isset($_GET['Indicadores'])){
			$model->setAttributes($_GET['Indicadores']);
		    	$dt = $model->buscquedaAtributosModelos();
		    	
		    	if(!empty($dt)){
		    		
		    		//foreach($datos as $dt):
		    		for($i=0; $i<count($dt); $i++){
		    			$recorrido = '';
		    			$d = array();//iniciando array
		    			if(!empty($dt[$i]['id'])){
		    				
		    			
		    				$d = Indicadores::model()->datosUnIndicador($dt[$i]['id']);
		    				$instrumentoNombre = Indicadores::model()->obtenerInstrumentosPorColumna($dt[$i]['id'], -1);
		    				$ponderacion = Indicadores::model()->obtenerPonderacionPorColumna($dt[$i]['id'], -1);
		    				if(!empty($instrumentoNombre)){
		    					
		    					$dt[$i]['instName'] = $instrumentoNombre;
		    				}else{
		    					$dt[$i]['instName']  = 'S.I.';
		    				}
		    				
		    				if(!empty($ponderacion)){
		    					
		    					$dt[$i]['ponderacion'] = $ponderacion;
		    				}else{
		    					$dt[$i]['ponderacion'] = 0;
		    				}
		    				
		    				if(!empty($d)){//se encontraron datos en la segunda busqueda

		    					//si vienen los datos necesarios para calcular el value
		    					if(!empty($d[0]['id'])&&!empty($d[0]['frecuenciaControl']['plazo_maximo'])&&!empty($d[0]['tipoFormula']['formula'])&&$d[0]['meta_anual']>=0&&$d[0]['tipoFormula']['tipo_resultado']>=0){
		    					
		    						$auxiliar=array();//iniciando array
									$c = new ConsultasView();
		    						$auxiliar = $c->construyendoBarras($d[0]['id'], $d[0]['frecuenciaControl']['plazo_maximo'],
									 $d[0]['tipoFormula']['formula'],$d[0]['meta_anual'],$d[0]['tipoFormula']['tipo_resultado']);
									 if($auxiliar['value'] != -1 && !empty($auxiliar['value'])){
									 	
									 	$dt[$i]['value2']= $auxiliar['value'];
									 	$dt[$i]['value']= $auxiliar['value'];;
									 }else{
									 	$dt[$i]['value2']= '-';
									 	$dt[$i]['value']= 'S.I.';
									 }
			    					 if($auxiliar['meta'] != -1 && !empty($auxiliar['meta'])){
			    					 	
										 $dt[$i]['esperado'] = $auxiliar['meta'];
									 }else{
									 	$dt[$i]['esperado']='-';
									 }
			    					 if(!empty($d[0]['meta_anual'])&&$d[0]['tipoFormula']['tipo_resultado']==0&&$dt[$i]['esperado']!='-'){
						 				
			    					 	if($d[0]['meta_anual']!=0){
										 	$dt[$i]['esperado'] = ($dt[$i]['esperado']*100)/$d[0]['meta_anual'];
			    					 	}else{
			    					 		$dt[$i]['esperado'] = ($dt[$i]['esperado']*100)/1;
			    					 	}	
									}
									
									 	$dt[$i]['value2']=$dt[$i]['value2'].' '.$d[0]['ascendente'].' '.$dt[$i]['esperado'];
								
									 
		    					}else{// fin si no vienen parametros vacios
		    							$dt[$i]['value2']= '-';
		    							$dt[$i]['value']= 'S.I.';
		    							$dt[$i]['esperado']='-';
										$dt[$i]['value2']=$dt[$i]['value2'].' '.$d[0]['ascendente'].' '.$dt[$i]['esperado'];
										
		    					}
		    					
		    				}else{//no se encontraron datos en la segunda busqueda
		    					
		    						$dt[$i]['value2']= '-';
		    						$dt[$i]['value']= 'S.I.';
		    						$dt[$i]['esperado']='-';
									$dt[$i]['value2']=$dt[$i]['value2'].' '.$d[0]['ascendente'].' '.$dt[$i]['esperado'];
										 
		    				}//fin else
		    			}
		    	
		    		}//fin for
		    		
		    	}//if
		    	$phpExcelPath = Yii::getPathOfAlias('application.vendors');
				spl_autoload_unregister(array('YiiBase','autoload'));
				include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
				$objPHPExcel = new PHPExcel();
		        $d = Yii::app()->session['excel-current'];
		        //inician style
		        $styleArray =array('font' => array('bold' => true,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),),'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation' => 90,'startcolor' => array('argb' => 'FFA0A0A0',),'endcolor' => array('argb' => 'FFFFFFFF',),),);
		        $fuenteNegrita = array('font' => array('bold' => true));
				$default_border = array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb'=>'1006A3'));
				$style_header = array('borders' => array('bottom' => $default_border,'left' => $default_border,'top' => $default_border,'right' => $default_border,),'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'E1E0F7'),),'font' => array('bold' => true,));	
				$style_cuerpo = array('borders' => array('bottom' => $default_border,'left' => $default_border,'top' => $default_border,'right' => $default_border,));
				//fin style
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(17);
				//dando style a cabeceras de tabla
				$objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray( $style_header );
				//combinando celdas para el titulo
		        $objPHPExcel->getActiveSheet()->mergeCells("B1:E1");
				//conformando el titulo, division y centro de costo
				$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
		        $objPHPExcel->getActiveSheet()->setCellValue('B1','INFORME AVANCE INDICADORES');
		        //cabeceras tabla
				$objPHPExcel->getActiveSheet()->setCellValue('A3','Centro de Responsabilidad');
		        $objPHPExcel->getActiveSheet()->setCellValue('B3','Centro Costo');
		        $objPHPExcel->getActiveSheet()->setCellValue('C3','Cargo');
		        $objPHPExcel->getActiveSheet()->setCellValue('D3','Tipo Producto');
		        $objPHPExcel->getActiveSheet()->setCellValue('E3','Producto Estratégico');
		        $objPHPExcel->getActiveSheet()->setCellValue('F3','Subproducto');
		        $objPHPExcel->getActiveSheet()->setCellValue('G3','Producto Específico');
		        $objPHPExcel->getActiveSheet()->setCellValue('H3','Indicador');
		        $objPHPExcel->getActiveSheet()->setCellValue('I3','Instrumento');
		        $objPHPExcel->getActiveSheet()->setCellValue('J3','Ponderación');
		        $objPHPExcel->getActiveSheet()->setCellValue('K3','Porcentaje (%)');
		        
		        $i=4;
		 		for($t=0; $t<count($dt); $t++){
		 		
		 			
		 		    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray( $style_cuerpo );
		 		    $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray( $style_cuerpo );
		 		    $objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray( $style_cuerpo );
		 		    $objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray( $style_cuerpo );
		 		    $objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray( $style_cuerpo );
		 		    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray( $style_cuerpo );
		 		    $objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray( $style_cuerpo );
		 		    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray( $style_cuerpo );
		 		    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray( $style_cuerpo );
		 		    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray( $style_cuerpo );
		 		 	$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray( $style_cuerpo );
		 		 	
		 		    //imprimiendo valores
		            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i ,''.$dt[$t]['divisionNombre']);
		            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i ,''.$dt[$t]['centroCostoNombre']);
		            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i ,''.$dt[$t]['cargoNombre']);
		            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i ,''.$dt[$t]['tipoProductoEstrategico']);
		            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i ,''.$dt[$t]['productoEstrategicoNombre']);
		            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i ,''.$dt[$t]['subproductoNombre']);
		            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i ,''.$dt[$t]['productoEspecificoNombre']);
		            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i ,''.$dt[$t]['nombre']);
		           	$objPHPExcel->getActiveSheet()->setCellValue('I'.$i ,''.$dt[$t]['instName']);
		           	$objPHPExcel->getActiveSheet()->setCellValue('J'.$i ,''.$dt[$t]['ponderacion']);
		           	$objPHPExcel->getActiveSheet()->setCellValue('K'.$i ,''.$dt[$t]['value']);
		       
		            
		            $i++;
		        }//fin for
		
		       
		 
		      	header('Content-Type: application/vnd.ms-excel');
		        header('Content-Disposition: attachment;filename="indicadoresReporte.xls"');
		        header('Cache-Control: max-age=0');
		        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		        $objWriter->save('php://output');
		}//fin si vienen datos por get

	}

	
	//funcion que lleva a detalles de un indicador desde el boton lupa
	public function actionUpdate($idi) {
		
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
					  				
					    			if($diasTotales != 0){
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
		
		$this->layout = '//layouts/iframe';
		$this->render('viewIndicador', array(
				'id'=>$idi, 
				'arr'=>$indi,
				'hitos'=>$hitos,
				'meses'=>$meses,
				'dataProvider'=>$dataProvider
				
		));
	}//fin funcion update

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
            //'nombre_i'=>$_GET['nombre_i'],
            //'nombre_productoEst'=>$_GET['nombre_productoEst'],
            //'nombre_productoEsp'=>$_GET['nombre_productoEsp'],
            //'nombre_sub'=>$_GET['nombre_sub'],
            'frecuenciaControl'=>$frecuenciaControl,    
        )); 
        
    }


	
	public function actionIndex() {            
		   $bandera = 0;
		   $model=new Indicadores('buscquedaAtributosModelos');
		
		    $model->unsetAttributes();
			$dt = $model->buscquedaAtributosModelos();
		    if(isset($_GET['Indicadores'])){
		    	$dt = array();
		    	
				$model->setAttributes($_GET['Indicadores']);
		    	$dt = $model->buscquedaAtributosModelos();
		    
		    	if(!empty($dt)){
		    		
		    	//	foreach($datos as $dt):
		    	for($i=0; $i<count($dt); $i++){
		    			$recorrido = '';
		    			$d = array();//iniciando array
		    			if(!empty($dt[$i]['id'])){
		    				
		    			
		    				$d = Indicadores::model()->datosUnIndicador($dt[$i]['id']);
		    				
		    				if(!empty($d)){//se encontraron datos en la segunda busqueda

		    					//si vienen los datos necesarios para calcular el value
		    					if(!empty($d[0]['id'])&&!empty($d[0]['frecuenciaControl']['plazo_maximo'])){
		    					
		    						$auxiliar=array();//iniciando array
									$c = new ConsultasView();
		    						$auxiliar = $c->construyendoBarras($d[0]['id'], $d[0]['frecuenciaControl']['plazo_maximo']);
		    						
		    						if($auxiliar['value'] != -1 && $auxiliar['value']>=0){
									 	
									 	$dt[$i]['value2']= $auxiliar['value'];
									 	$dt[$i]['value']= $auxiliar['value'];;
									 }else{
									 	$dt[$i]['value2']= '-';
									 	$dt[$i]['value']= 'S.I.';
									 }
			    					 if($auxiliar['meta'] != -1 && $auxiliar['meta']>=0){
			    					 	
										 $dt[$i]['esperado'] = $auxiliar['meta'];
									 }else{
									 	$dt[$i]['esperado']='-';
									 }		
															
									 	$dt[$i]['value2']=$dt[$i]['value2'].' '.$d[0]['ascendente'].' '.$dt[$i]['esperado'].' '.$auxiliar['bandera'];
								
									 
		    					}else{// fin si no vienen parametros vacios
		    							$dt[$i]['value2']= '-';
		    							$dt[$i]['value']= 'S.I.';
		    							$dt[$i]['esperado']='-';
										$dt[$i]['value2']=$dt[$i]['value2'].' '.$d[0]['ascendente'].' '.$dt[$i]['esperado'].' '.'0';
										
		    					}
		    			
		    				}else{//no se encontraron datos en la segunda busqueda
		    					
		    						$dt[$i]['value2']= '-';
		    						$dt[$i]['value']= 'S.I.';
		    						$dt[$i]['esperado']='-';
									$dt[$i]['value2']=$dt[$i]['value2'].' '.$d[0]['ascendente'].' '.$dt[$i]['esperado'].' '.'0';
										 
		    				}//fin else
		    			}
		    		
		    	}//fin for
	
		    	}//if
		    }
	
				 $dataProvider = new CArrayDataProvider($dt, 
						array(
							'keyField' => 'id',         
							'id' => 'data',
						  'pagination'=>array(
						        'pageSize'=>10,
						    ),                     
						)
				);
			    
			    $this->render('index',array(
			        'dataProvider'=>$dataProvider,
			    	
			    ));
		    
	}
    
	
		
/*
    
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
    }*/
    
    //obtiene los centros de costos asociados a los indicadores segun la division
    public function actionObtenerCentrosCostos($id){
    	$centros = CentrosCostos::model()->findAll(array('condition'=>'division_id = '.$id.' AND estado = 1') );

		header("Content-type: application/json");
		echo CJSON::encode($centros);
    	
    }
    //obtiene todos los responsables de indicadores asociados a un centro de costo seleccionado
    public function actionObtenerGestores($id){
    
    	$responsables = User::responsablesPorCentroCosto($id);
    
		header("Content-type: application/json");
		$json = CJSON::encode($responsables);
		echo $json;
    	
    }
    
    public function actionObtenerProductosEstrategicos($idTipo, $idCR, $idCC){
    
    	$productos = ProductosEstrategicos::productosEstrategicosFiltroReporteAvanceIndicadores($idTipo, $idCR, $idCC);
    
		header("Content-type: application/json");
		$json = CJSON::encode($productos);
		echo $json;
    	
    }
    
    public function actionObtenerSubproductos($id){
    
    	$subproductos = Subproductos::subproductosPorProductoEstrategico($id);
    
		header("Content-type: application/json");
		$json = CJSON::encode($subproductos);
		echo $json;
    	
    }
    
    public function actionObtenerProductoEspecifico($id){
    
    	$preEspecificos = ProductosEspecificos::productoEspecificoPorSub($id);
    
		header("Content-type: application/json");
		$json = CJSON::encode($preEspecificos);
		echo $json;
    	
    }
    
    public function actionObtenerObservacion($id){
    	
    	$model = new IndicadoresObservaciones();
    	$observaciones = $model->buscaObs($id);
    	//$indicadores = Indicadores::indicadoresPorProductoEspecifico($id);
    
		header("Content-type: application/json");
		$json = CJSON::encode($observaciones);
		echo $json;
    	
    }

    


}

?>