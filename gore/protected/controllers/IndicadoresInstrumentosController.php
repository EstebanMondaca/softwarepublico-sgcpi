<?php

class IndicadoresInstrumentosController extends GxController {
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
    
    public function accessRules() {
          return array(
            array('allow',
                'actions'=>array('index','excel'),                
                'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
            ),
            array('allow',
                'actions'=>array('update','create','delete','admin'), //'minicreate', 'create', 'update', 'admin', 'delete'
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    } 
	

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'IndicadoresInstrumentos'),
		));
	}

	public function actionCreate() {
		$model = new IndicadoresInstrumentos;


		if (isset($_POST['IndicadoresInstrumentos'])) {
			$model->setAttributes($_POST['IndicadoresInstrumentos']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'IndicadoresInstrumentos');


		if (isset($_POST['IndicadoresInstrumentos'])) {
			$model->setAttributes($_POST['IndicadoresInstrumentos']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
	
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'IndicadoresInstrumentos')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
	
	//Consultamos que contenga le periodo	
	if(!isset(Yii::app()->session['idPeriodo'])){
		//si el no tiene el periodo redireccione al site para seleccionar
		Yii::app()->request->redirect(Yii::app()->getHomeUrl());	
	}
	
	
		$model = new IndicadoresInstrumentos('search');
		$model->unsetAttributes();
		
		$indicadores = new Indicadores('listadoFiltrado');
		$indicadores->unsetAttributes();
		
		 /*********************
		  	    $_POST 
		  ********************/
		if (isset($_POST['indicadoresInstrumentos']) && (Yii::app()->user->checkAccess("admin"))) {
			$indicadoresIpost = $_POST['indicadoresInstrumentos'];
			 if(count($indicadoresIpost)>0)
	         {
	         	/*foreach($indicadores as $indicador_=>$id){   
	         		
	         		//Cambiamos el estado de los instrumentos a 0
	         		IndicadoresInstrumentos::model()->updateAll(array('estado'=>0),'estado="1" AND id_indicador='.$indicador_);
	         	
	         	}*/
	         	//$indicadoresIpost->cr_id;
	         	//IndicadoresInstrumentos::model()->updateAll(array('estado'=>1),'estado="0"');
	         	
	         	$criteria = new CDbCriteria;
	         	
	         	$criteria->join='
	         					INNER JOIN indicadores on t.id_indicador = indicadores.id
								LEFT JOIN clasificaciones_ambitos AS claambito on indicadores.clasificacion_ambito_id = claambito.id 
								LEFT JOIN lineas_accion la on indicadores.id=la.id_indicador      
								LEFT JOIN productos_especificos AS pes on indicadores.producto_especifico_id=pes.id							
	                			LEFT JOIN subproductos AS sp on pes.subproducto_id=sp.id                			
				                INNER JOIN productos_estrategicos AS pe on sp.producto_estrategico_id=pe.id or la.producto_estrategico_id=pe.id
				                INNER JOIN divisiones  ON  pe.division_id = divisiones.id
				                INNER JOIN objetivos_productos AS op ON pe.id = op.producto_estrategico_id
				                INNER JOIN objetivos_estrategicos AS oe ON op.objetivo_estrategico_id = oe.id
				                INNER JOIN desafios_objetivos AS do2 ON  oe.id = do2.objetivo_estrategico_id
				                INNER JOIN desafios_estrategicos AS de ON do2.desafio_estrategico_id = de.id
				                INNER JOIN planificaciones AS pl ON de.planificacion_id = pl.id 
				                INNER JOIN periodos_procesos AS pp ON pl.periodo_proceso_id = pp.id';
	        
	        $criteria->condition = 'indicadores.estado = 1 AND pp.id = '.Yii::app()->session['idPeriodo'];
	    	$criteria->addCondition('divisiones.id= :division_id');
			$criteria->params[':division_id'] = $_POST['cr_id']; // bind your parameter
	        $criteria->distinct =true;
	        $modelii=IndicadoresInstrumentos::model()->findAll($criteria);
	        foreach($modelii as $value)   
	         	{
	         		IndicadoresInstrumentos::model()->updateAll(array('estado'=>0),'estado="1" AND id='.$value->id);
	         	}
	        //IndicadoresInstrumentos::model()->updateAll(array('t.estado'=>0),$criteria);	
	        
	        
	         	
	         	
	         	foreach($indicadoresIpost as $instrumento=>$fielId)   
	         	{
	         		//Busca los instrumentos PMG - CDC - MG - T - FH 
	         		$SQLinstrumento = Instrumentos::model()->find(
	         			array('select'=>'t.id',
	         				  'condition'=>'t.nombre ="'.$instrumento.'"  AND t.estado=1',
	         				)
	         		);
	         		//echo "Instrumento=";
	         		//echo $SQLinstrumento->id;
	         		//echo "----";
		         	 
		         	 
		         					 		
	         		foreach($fielId as $id_Indicador=>$ponderacion)  
	         		{
	         		//	echo "Indicador=";
	         		//	echo $id_Indicador;	
	         		//	echo "----";
	         		//	print_r($fielId);
	         			
		         			$modelIndicadoresInstrumento=IndicadoresInstrumentos::model()->find(
		         			'id_indicador=:id_indicador AND id_instrumento=:id_instrumento',
		         			array(':id_indicador'=>$id_Indicador,':id_instrumento'=>$SQLinstrumento->id)
		         			);
		         			
		         			if ($modelIndicadoresInstrumento===null) {
		         				//echo "--guardar--";	
		         				$modelNew = new IndicadoresInstrumentos;
		    					$modelNew->id_indicador=$id_Indicador;
		    					$modelNew->id_instrumento=$SQLinstrumento->id;
		    					$modelNew->ponderacion= $ponderacion;
		    					$modelNew->estado= '1';
		    					$modelNew->save();
	
		         			}else{
		         				//echo "actualizar ";
		         					 $modelIndicadoresInstrumento->ponderacion = $ponderacion;
		         					 $modelIndicadoresInstrumento->estado= '1';
		         					 $modelIndicadoresInstrumento->update();
		         				//echo "_--_";
		         			}		
	         		}	         		
	         	}  
	         }			
		}
		/*********************
		  	END  $_POST 
		********************/
		
		
		

		if (isset($_GET['Indicadores']))
			$indicadores->setAttributes ($_GET['Indicadores']);
			
		
		if(Yii::app()->user->checkAccess("admin")){
		    $this->render('admin', array(
                'model' => $model,
                'indicadores' => $indicadores,  
            ));
		}else{
		    $this->render('index', array(
                'model' => $model,
                'indicadores' => $indicadores,  
            ));
		}
        
	}

	public function actionAdmin() {
		$model = new IndicadoresInstrumentos('search');
		$model->unsetAttributes();

		if (isset($_GET['IndicadoresInstrumentos']))
			$model->setAttributes($_GET['IndicadoresInstrumentos']);
			
			/*if(Yii::app()->request->getParam('export')) {
	    		$this->actionExport();
	    		Yii::app()->end();
			}*/

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	

    	
 public function actionExcel($id) {
 	
 		$criteria = new CDbCriteria;
	
		//INNER JOIN indicadores_instrumentos AS inins on t.id=inins.id_indicador
		/*
		 * 
		 (($data->centro_costo_id=="")?
		 
		 				Indicadores::model()->find(array(
						"condition" => "t.estado =1 AND t.id =$data->id  AND producto_especifico_id IS NULL",
						"join" => "INNER JOIN lineas_accion li ON t.id = li.id_indicador 
								   LEFT JOIN centros_costos cc ON li.centro_costo_id = cc.id",
						"select" => "cc.nombre",		   
						)):
						
						CentrosCostos::model()->find("estado=1 AND id=$data->centro_costo_id"))
						
						SELECT cc.nombre 
 				FROM indicadores 
 				INNER JOIN lineas_accion li ON id = li.id_indicador
 				LEFT JOIN centros_costos cc ON li.centro_costo_id = cc.id
 				WHERE estado= 1  AND producto_especifico_id IS NULL
 				
 					(SELECT cc.nombre 
 				FROM indicadores 
 				INNER JOIN lineas_accion li ON id = li.id_indicador
 				LEFT JOIN centros_costos cc ON li.centro_costo_id = cc.id
 				WHERE indicadores.estado= 1  AND producto_especifico_id IS NULL 
 				limit 1,1)
 				
 				
 				SELECT centros_costos.nombre
 				FROM centros_costos
 				WHERE centros_costos.estado=1  AND centros_costos.id = 2 
						
		*/
		$criteria->select='t.*,cc.nombre as _centroCostoNombre, la.nombre as la_nombre, sp.centro_costo_id, pes.nombre as producto_especifico_n, 
				case when t.asociacion_id = 1 or t.asociacion_id = 2 then "MG" when t.asociacion_id = 3 then "PMG" else " " end as mg,
				sp.nombre as subproducto_n, pe.nombre as producto_estrategico_n, cargos.nombre as cargo, divisiones.nombre as division_n,
				claambito.nombre as ambito_n, divisiones.id as division_id,
				(SELECT ponderacion FROM indicadores_instrumentos WHERE id_indicador= t.id AND id_instrumento=4 AND estado=1) as ponderaciont,
				(SELECT ponderacion FROM indicadores_instrumentos WHERE id_indicador= t.id AND id_instrumento=2 AND estado=1) as ponderacioncdc,
				(SELECT ponderacion FROM indicadores_instrumentos WHERE id_indicador= t.id AND id_instrumento=5 AND estado=1) as ponderacionfh,
				(SELECT ponderacion FROM indicadores_instrumentos WHERE id_indicador= t.id AND id_instrumento=1 AND estado=1) as ponderacionpmg,
				(SELECT ponderacion FROM indicadores_instrumentos WHERE id_indicador= t.id AND id_instrumento=3 AND estado=1) as ponderacionmg';
		
			$criteria->join=' 	INNER JOIN users  on t.responsable_id= users.id
								INNER JOIN cargos on users.cargo_id = cargos.id
								LEFT JOIN clasificaciones_ambitos AS claambito on t.clasificacion_ambito_id = claambito.id 
								LEFT JOIN lineas_accion la on t.id=la.id_indicador      
								LEFT JOIN productos_especificos AS pes on t.producto_especifico_id=pes.id							
	                			LEFT JOIN subproductos AS sp on pes.subproducto_id=sp.id   
	                			LEFT JOIN centros_costos cc on cc.id=sp.centro_costo_id or cc.id=la.centro_costo_id             			
				                INNER JOIN productos_estrategicos AS pe on sp.producto_estrategico_id=pe.id or la.producto_estrategico_id=pe.id
				                INNER JOIN divisiones  ON  pe.division_id = divisiones.id
				                INNER JOIN objetivos_productos AS op ON pe.id = op.producto_estrategico_id
				                INNER JOIN objetivos_estrategicos AS oe ON op.objetivo_estrategico_id = oe.id
				                INNER JOIN desafios_objetivos AS do2 ON  oe.id = do2.objetivo_estrategico_id
				                INNER JOIN desafios_estrategicos AS de ON do2.desafio_estrategico_id = de.id
				                INNER JOIN planificaciones AS pl ON de.planificacion_id = pl.id 
				                INNER JOIN periodos_procesos AS pp ON pl.periodo_proceso_id = pp.id';
        $criteria->distinct =true;
            
        $criteria->addCondition('divisiones.id='.$id.' AND t.estado = 1 AND pp.id = '.Yii::app()->session['idPeriodo']);
        
        $criteria->order='sp.centro_costo_id ASC';
        
		$data = Indicadores::model()->findAll($criteria); 
		

       //	$model = new IndicadoresInstrumentos();
       	
       	
       //	$data = $model->findAll();
       	

       	
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
    	$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(5);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(40);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(40);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(40);
    	$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(20);
    	
    	//Cambiando estilo del header
    	$objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray(array("font" => array( "bold" => true, "size" => '15')));
		//$objPHPExcel->getActiveSheet()->getStyle("A2:M2")->applyFromArray(array("font" => array( "bold" => true, "center" => true)));
    	//dando style a cabeceras de tabla
		$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($style_header);
    	
		//Colorear Celdas
    	//$objPHPExcel->getActiveSheet()->getStyle("A2:M2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	//$objPHPExcel->getActiveSheet()->getStyle("A2:M2")->getFill()->getStartColor()->setRGB('C0C0C0');

    	//Union de dos celdas
        $objPHPExcel->getActiveSheet()->mergeCells("A1:M1");
        $objPHPExcel->getActiveSheet()->setCellValue('A1','Resumen en indicadores asignados a instrumentos');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);

        //Union de dos celdas
        $objPHPExcel->getActiveSheet()->mergeCells("I2:J2");
        
		//Asignamos los titulos
		$objPHPExcel->getActiveSheet()->setCellValue('A2','Nº');
        $objPHPExcel->getActiveSheet()->setCellValue('B2','Ámbito');
        $objPHPExcel->getActiveSheet()->setCellValue('C2','C.R.');
        $objPHPExcel->getActiveSheet()->setCellValue('D2','C.C.');
        $objPHPExcel->getActiveSheet()->setCellValue('E2','Prod. Estrategico');
        $objPHPExcel->getActiveSheet()->setCellValue('F2','SubProducto');
        $objPHPExcel->getActiveSheet()->setCellValue('G2','Prod. Específico /AMI/LA');
        $objPHPExcel->getActiveSheet()->setCellValue('H2','Indicador');
        $objPHPExcel->getActiveSheet()->setCellValue('I2','MG');
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($styleCuerpoUnion);
        $objPHPExcel->getActiveSheet()->setCellValue('K2','F.H');
        $objPHPExcel->getActiveSheet()->setCellValue('L2','CDC');
        $objPHPExcel->getActiveSheet()->setCellValue('M2','T');
     	
        
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
 		    $objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray( $style_cuerpo );
 		    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray( $style_cuerpo );
 		    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray( $style_cuerpo );
 		    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray( $style_cuerpo );
 		    $objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray( $style_cuerpo );
 		    $objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray( $style_cuerpo );
 		   	$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray( $style_cuerpo );
 		    
 		     //imprimiendo valores
 			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i ,$numero);
 	        $objPHPExcel->getActiveSheet()->setCellValue('B'.$i ,$record->ambito_n);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i ,$record->division_n);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i ,$record->_centroCostoNombre);
            
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i ,$record->producto_estrategico_n);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i ,$record->subproducto_n);
            if(isset($record->producto_especifico_n)){
            	$objPHPExcel->getActiveSheet()->setCellValue('G'.$i ,$record->producto_especifico_n);
            }else{
            	$objPHPExcel->getActiveSheet()->setCellValue('G'.$i ,$record->la_nombre);
            }
            
            //$objPHPExcel->getActiveSheet()->setCellValue('G'.$i ,$record->producto_especifico_n);
            
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i ,$record->nombre);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i ,$record->mg);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i ,$record->ponderacionpmg.$record->ponderacionmg);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i ,$record->ponderacionfh);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i ,$record->ponderacioncdc);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i ,$record->ponderaciont);

                                                                                                                                                
            $i++;//Aumentar celda
            $numero++;//Aumentar numero de items
        }
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="indicadoresInstrumentos.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        
      
       
}



}