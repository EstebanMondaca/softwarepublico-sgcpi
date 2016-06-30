<?php

class EjecucionPresupuestariaController extends GxController {

    public function filters() {
    return array(
            'accessControl', 
            );
    }

    public function accessRules() {                  
          return array(            
            array('allow',
               	'actions'=>array('index','view', 'excel2', 'admin', 'obtenerCentros'),    
            	'roles'=>array('gestor','finanzas','supervisor','supervisor2'),   
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    } 
	public function actionView() {
		$this->layout = '//layouts/iframe';
       	$this->render('view', array(
                'nombre'=>$nombreP,
       			'id'=>$id, 'dataProvider'=>$dataProvider,
       			'title'=>$title
     
        ));
	}
	



	public function actionIndex() {
     
		$model = new EjecucionPresupuestaria('search');
		$model->unsetAttributes();
		$bandera = 0;
		$bandera2 = 0;
		$dataProvider = $model->busquedaPersonalizada(1,1);
		
		if (isset($_GET['EjecucionPresupuestaria'])){
			$model->setAttributes($_GET['EjecucionPresupuestaria']);
			$dataProvider = $model->busquedaPersonalizada($_GET['EjecucionPresupuestaria']['id_division'],$_GET['EjecucionPresupuestaria']['id_centro_costo']);
		}
		if(isset($_POST['eP'])) {
	
			
			$datosPost= $_POST['eP'];

			if(count($datosPost)>0){
		
					foreach($datosPost as $idItem=>$data):
						
					
							
							if(!empty($datosPost[$idItem]['id'])){//se trata de un update
									
									$modelEjecucionPresupuestaria = EjecucionPresupuestaria::model()->findAll(
			         				array('select'=>'*',
			         				  'condition'=>'t.id ="'.$datosPost[$idItem]['id'].'"  AND t.estado=1',
			         				)
			         				);
								
			         				if(count($modelEjecucionPresupuestaria)!=0){
			         					
			         					if($modelEjecucionPresupuestaria[0]->mes1 !=$datosPost[$idItem]['mes1']){
					        			$modelEjecucionPresupuestaria[0]->mes1 =$datosPost[$idItem]['mes1'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->mes2 !=$datosPost[$idItem]['mes2']){
					        			$modelEjecucionPresupuestaria[0]->mes2 =$datosPost[$idItem]['mes2'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->mes3 !=$datosPost[$idItem]['mes3']){
					        			$modelEjecucionPresupuestaria[0]->mes3 =$datosPost[$idItem]['mes3'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->mes4 !=$datosPost[$idItem]['mes4']){
					        			$modelEjecucionPresupuestaria[0]->mes4 =$datosPost[$idItem]['mes4'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->mes5 !=$datosPost[$idItem]['mes5']){
					        			$modelEjecucionPresupuestaria[0]->mes5 =$datosPost[$idItem]['mes5'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->mes6 !=$datosPost[$idItem]['mes6']){
					        			$modelEjecucionPresupuestaria[0]->mes6 =$datosPost[$idItem]['mes6'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->mes7 !=$datosPost[$idItem]['mes7']){
					        			$modelEjecucionPresupuestaria[0]->mes7 =$datosPost[$idItem]['mes7'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->mes8 !=$datosPost[$idItem]['mes8']){
					        			$modelEjecucionPresupuestaria[0]->mes8 =$datosPost[$idItem]['mes8'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->mes9 !=$datosPost[$idItem]['mes9']){
					        			$modelEjecucionPresupuestaria[0]->mes9 =$datosPost[$idItem]['mes9'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->mes10 !=$datosPost[$idItem]['mes10']){
					        			$modelEjecucionPresupuestaria[0]->mes10 =$datosPost[$idItem]['mes10'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->mes11 !=$datosPost[$idItem]['mes11']){
					        			$modelEjecucionPresupuestaria[0]->mes11 =$datosPost[$idItem]['mes11'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->mes12 !=$datosPost[$idItem]['mes12']){
					        			$modelEjecucionPresupuestaria[0]->mes12 =$datosPost[$idItem]['mes12'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->acumulado !=$datosPost[$idItem]['acumulado']){
					        			$modelEjecucionPresupuestaria[0]->acumulado =$datosPost[$idItem]['acumulado'];
					        			}
					        			if($modelEjecucionPresupuestaria[0]->saldo != $datosPost[$idItem]['saldo']){
					        			$modelEjecucionPresupuestaria[0]->saldo =$datosPost[$idItem]['saldo'];
					        			}
					        			$modelEjecucionPresupuestaria[0]->update();
					        		
					        			$model->setAttributes($modelEjecucionPresupuestaria[0]);
			         					
			         				}
							}else{
										$id_planificacion = Yii::app()->session['idPlanificaciones'];
										$ejecucionNueva= new EjecucionPresupuestaria;
				                      	$ejecucionNueva->id_division= $datosPost[$idItem]['id_division'];;
				                        $ejecucionNueva->id_centro_costo= $datosPost[$idItem]['cc'];
				                        $ejecucionNueva->id_planificacion=$id_planificacion;
				                        $ejecucionNueva->id_item_presupuestario = $datosPost[$idItem]['id_item'];
				                        $ejecucionNueva->monto_asignado = $datosPost[$idItem]['asignado'];
				                        $ejecucionNueva->acumulado = $datosPost[$idItem]['acumulado'];
				                        $ejecucionNueva->saldo = $datosPost[$idItem]['saldo'];
				                        $ejecucionNueva->mes1 = $datosPost[$idItem]['mes1'];
				                        $ejecucionNueva->mes2 = $datosPost[$idItem]['mes2'];
				                        $ejecucionNueva->mes3 = $datosPost[$idItem]['mes3'];
				                        $ejecucionNueva->mes4 = $datosPost[$idItem]['mes4'];
				                        $ejecucionNueva->mes5 = $datosPost[$idItem]['mes5'];
				                        $ejecucionNueva->mes6 = $datosPost[$idItem]['mes6'];
				                        $ejecucionNueva->mes7 = $datosPost[$idItem]['mes7'];
				                        $ejecucionNueva->mes8 = $datosPost[$idItem]['mes8'];
				                        $ejecucionNueva->mes9 = $datosPost[$idItem]['mes9'];
				                        $ejecucionNueva->mes10 = $datosPost[$idItem]['mes10'];
				                        $ejecucionNueva->mes11 = $datosPost[$idItem]['mes11'];
				                        $ejecucionNueva->mes12 = $datosPost[$idItem]['mes12'];
				                        $ejecucionNueva->estado = 1;
				                        $ejecucionNueva->save();
				                    
							        	$model->setAttributes($ejecucionNueva);
							}

			         		$bandera = $datosPost[$idItem]['cc'];
			        		$bandera2 = $datosPost[$idItem]['id_division'];
						
			        endforeach;
			       
			      //  $dataProvider=$model->busquedaPersonalizada($bandera2, $bandera);
				}//fin if
		}
    	
		$idUser = Yii::app()->user->id;
		$usuarioActivo = User::model()->find(array('condition'=>'id='.$idUser));
		$idCargo = $usuarioActivo->cargo->id;
		
		if(Yii::app()->user->checkAccess("finanzas")){//si es finanzas
			$this->render('index', array(
	
				'dataProvider' => $dataProvider, 'bandera' =>$bandera, 'bandera2' => $bandera2
			
			));
		}else{
			$this->render('view', array(
	
				'dataProvider' => $dataProvider, 'bandera' =>$bandera, 'bandera2' => $bandera2
			
			));
		}
	}
    
	public function actionAdmin($id){
			$centros = CentrosCostos::model()->findAll(array('condition'=>'division_id = '.$id.' AND estado = 1') );

		header("Content-type: application/json");
		echo CJSON::encode($centros);
	

	}
    
   /* protected function validateAccess(){
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
    
	public function actionObtenerCentros($id){
		
		
		$centros = CentrosCostos::model()->findAll(array('condition'=>'division_id = '.$id.' AND estado = 1') );

		header("Content-type: application/json");
		echo CJSON::encode($centros);
	}
	


public function actionExcel2($id, $id2, $nombreDivision, $nombreCC) {
		$model= new EjecucionPresupuestaria();
       	$data2 = $model->busquedaPersonalizada($id, $id2);
       	$data =  $data2->getData();

       $phpExcelPath = Yii::getPathOfAlias('application.vendors');
		spl_autoload_unregister(array('YiiBase','autoload'));
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
		
 		// creamos un OBJETO de la clase PHPExcel():
        $objPHPExcel = new PHPExcel();
        
        $d = Yii::app()->session['excel-current'];
        
        //style titulo principal
		$styleArray =
			 array('font' => 
			 array('bold' => true,),
			 'alignment' => 
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			 'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),)
			 ,'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation' => 90,
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
 
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(17);
		//dando style a cabeceras de tabla
		$objPHPExcel->getActiveSheet()->getStyle('A6:P6')->applyFromArray( $style_header );

		//combinando celdas para el titulo
        $objPHPExcel->getActiveSheet()->mergeCells("D1:I1");
		//conformando el titulo, division y centro de costo
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C3:C4')->applyFromArray($fuenteNegrita);
        $objPHPExcel->getActiveSheet()->setCellValue('D1','INFORME EJECUCIÓN PRESUPUESTARIA');
        $objPHPExcel->getActiveSheet()->setCellValue('A3','CENTRO DE RESPONSABILIDAD: ');
        $objPHPExcel->getActiveSheet()->setCellValue('A4','CENTRO DE COSTO:');
        

       	$objPHPExcel->getActiveSheet()->setCellValue('C3',$nombreDivision);
        $objPHPExcel->getActiveSheet()->setCellValue('C4',$nombreCC);
    
        //cabeceras tabla
		$objPHPExcel->getActiveSheet()->setCellValue('A6','Item Presupuestario');
        $objPHPExcel->getActiveSheet()->setCellValue('B6','Monto Asignado');
        $objPHPExcel->getActiveSheet()->setCellValue('C6','Enero');
        $objPHPExcel->getActiveSheet()->setCellValue('D6','Febrero');
        $objPHPExcel->getActiveSheet()->setCellValue('E6','Marzo');
        $objPHPExcel->getActiveSheet()->setCellValue('F6','Abril');
        $objPHPExcel->getActiveSheet()->setCellValue('G6','Mayo');
        $objPHPExcel->getActiveSheet()->setCellValue('H6','Junio');
        $objPHPExcel->getActiveSheet()->setCellValue('I6','Julio');
        $objPHPExcel->getActiveSheet()->setCellValue('J6','Agosto');
        $objPHPExcel->getActiveSheet()->setCellValue('K6','Septiembre');
        $objPHPExcel->getActiveSheet()->setCellValue('L6','Octubre');
        $objPHPExcel->getActiveSheet()->setCellValue('M6','Noviembre');
        $objPHPExcel->getActiveSheet()->setCellValue('N6','Diciembre');
         $objPHPExcel->getActiveSheet()->setCellValue('O6','Monto Acumulado');
          $objPHPExcel->getActiveSheet()->setCellValue('P6','Saldo');
     
    
				$i=7;
		 		foreach($data as $record):
		 			//dando style a cada una de las celdas
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
		 		    $objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray( $style_cuerpo );
		 		   	$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray( $style_cuerpo );
		 		   	$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->applyFromArray( $style_cuerpo );
		 		   	$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray( $style_cuerpo );
		 		    $objPHPExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray( $style_cuerpo );
		 		    //imprimiendo valores
		            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i ,$record['item_nom']);
		            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i ,$record['monto_asignado']);
		            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i ,$record['mes1']);
		            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i ,$record['mes2']);
		            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i ,$record['mes3']);
		            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i ,$record['mes4']);
		            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i ,$record['mes5']);
		            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i ,$record['mes6']);
		            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i ,$record['mes7']);
		            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i ,$record['mes8']);
		            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i ,$record['mes9']);
		            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i ,$record['mes10']);
		            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i ,$record['mes11']);
		            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i ,$record['mes12']);
		            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i ,$record['acumulado']);
		            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i ,$record['saldo']);
		            
		            $i++;
		       endforeach;
		     

    
   
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="indicadoresInstrumentos.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        
      
       
}


    public static function  calcularMontoAsignadoPorCentroDeCosto(){
    
        $SQl="Select BB.*,ejp.id
            FROM(
                SELECT cc.division_id,AA.centro_costo_id,AA.planificacion_id, AA.item_presupuestario_id,SUM(AA.monto) as monto_asignado
                FROM(
                    SELECT COALESCE(SUM(AAAA.monto),NULL) AS monto, AAAA.item_presupuestario_id, AAAA.centro_costo_id, AAAA.planificacion_id 
                    FROM(
                            SELECT pi.monto, pi.item_presupuestario_id, pi.centro_costo_id, pi.planificacion_id  
                            FROM  productos_itemes pi 
                            INNER JOIN itemes_presupuestarios ip on pi.item_presupuestario_id=ip.id
                            INNER JOIN centros_costos cc_1  on pi.centro_costo_id=cc_1.id
                            WHERE pi.planificacion_id = '".Yii::app()->session['idPlanificaciones']."' AND ip.estado=1 AND cc_1.estado=1
                            group by pi.monto,pi.item_presupuestario_id,pi.centro_costo_id,pi.planificacion_id
                    )AAAA
                                        group by AAAA.item_presupuestario_id,AAAA.centro_costo_id, AAAA.planificacion_id
                    UNION ALL
                    SELECT COALESCE(SUM(AAA.monto),NULL) AS monto, AAA.item_presupuestario_id,AAA.centro_costo_id, AAA.planificacion_id
                        FROM(
                            Select ia.actividad_id,ia.monto,ia.item_presupuestario_id,sp.centro_costo_id as centro_costo_id, de.planificacion_id as planificacion_id  
                            FROM  itemes_actividades ia INNER JOIN actividades act ON ia.actividad_id = act.id 
                            INNER JOIN itemes_presupuestarios ip on ia.item_presupuestario_id=ip.id
                            INNER JOIN indicadores ind ON act.indicador_id = ind.id 
                            INNER JOIN productos_especificos pes ON ind.producto_especifico_id=pes.id
                            INNER JOIN subproductos sp ON pes.subproducto_id=sp.id
                            INNER JOIN centros_costos cc_1  on sp.centro_costo_id=cc_1.id
                            INNER JOIN productos_estrategicos pe on sp.producto_estrategico_id=pe.id
                            INNER JOIN objetivos_productos op ON pe.id = op.producto_estrategico_id
                            INNER JOIN objetivos_estrategicos oe ON op.objetivo_estrategico_id = oe.id
                            INNER JOIN desafios_objetivos do2 ON  oe.id = do2.objetivo_estrategico_id
                            INNER JOIN desafios_estrategicos de ON do2.desafio_estrategico_id = de.id
                            WHERE de.planificacion_id = '".Yii::app()->session['idPlanificaciones']."' AND ind.estado = 1 AND act.estado=1 AND sp.estado=1 AND cc_1.estado=1
                            group by ia.actividad_id,ia.monto,ia.item_presupuestario_id,sp.centro_costo_id 
                            )AAA
                                            group by AAA.item_presupuestario_id,AAA.centro_costo_id, AAA.planificacion_id                
                ) AA
                INNER JOIN centros_costos cc ON AA.centro_costo_id=cc.id
                group by AA.item_presupuestario_id,AA.centro_costo_id,cc.division_id,AA.planificacion_id
            )BB
            LEFT JOIN ejecucion_presupuestaria ejp ON 
            BB.centro_costo_id=ejp.id_centro_costo AND BB.division_id=ejp.id_division AND BB.item_presupuestario_id=ejp.id_item_presupuestario AND BB.planificacion_id=ejp.id_planificacion";
    
        
        
        $list= Yii::app()->db->createCommand($SQl)->queryAll();
        foreach($list as $item){
            if(isset($item['id']) && !empty($item['id'])){//Realizamos un update
                $model = EjecucionPresupuestaria::model()->findByPk($item['id']);                
                $model->monto_asignado=$item['monto_asignado'];
                $model->save();
            }else{//Realizamos un insert
                $model=new EjecucionPresupuestaria;
                $model->id_division=$item['division_id'];
                $model->id_centro_costo=$item['centro_costo_id'];
                $model->id_planificacion=$item['planificacion_id'];
                $model->id_item_presupuestario=$item['item_presupuestario_id'];
                $model->monto_asignado=$item['monto_asignado'];
                $model->estado=1;
                $model->save();
            }    
        }        
        
    }
}
?>