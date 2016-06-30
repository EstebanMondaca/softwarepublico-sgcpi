<?php

class CierresInternosController extends GxController {

	public function filters() {
		return array(
			'accessControl', 
			);
	}


	/* *************************************************
	 * accessRules
	 * ------------------------------------------
	 * Reglas del control de acceso 
	 * Permite las acciones a los roles y a las vistas solo al administrador
	 * **************************************************/
    public function accessRules() {

          return array(
             array('allow',
                'actions'=>array('view','viewCierre','cierreInterno'),   
          		'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
             ),
            array('allow',
                'actions'=>array('update','updateCierre','borrar','create','createCierre','cierreEtapa'),                
                'roles'=>array('admin'),
           	),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
	
    
	

/*
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('CierresInternos');
		
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new CierresInternos('search');
		$model->unsetAttributes();

		if (isset($_GET['CierresInternos']))
			$model->setAttributes($_GET['CierresInternos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
 	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'CierresInternos')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}
	
	*/
		
	public function actionCreate($id) {
		//$id = id_etapa;
		
		$model = new CierresInternos;

		//Buscamos el id del periodo
		$wherePeriodoProcesos = PeriodosProcesos::model()->find("id =".Yii::app()->session['idPeriodo']);
		//Buscamos la planificacion que está asociada al periodo actual seleccionado
		$wherePlanificaciones = Planificaciones::model()->find("estado = 1 AND periodo_proceso_id =".$wherePeriodoProcesos->id);
		//Asignamos el identificador de la planificaion del periodo actual
		
		$idPlanificaciones = $wherePlanificaciones->id;
		
		$etapa = Etapas::model()->find("id=".$id);
		$nombreEtapa = "";
		
		
		if (isset($_POST['CierresInternos'])) {
			
			$model->setAttributes($_POST['CierresInternos']);
			
			$model->documento=CUploadedFile::getInstance($model,'documento');
			
			$nombrePDF = str_replace(' ', '_', $model->documento);
			
			$nombrePDF = date("Y_m_d_H:i:s").$nombrePDF;
			
			$textoLimpio = preg_replace('([^A-Za-z0-9._])', '', $nombrePDF);
			
			$nombrePDF = $textoLimpio;
			
			$model->archivo = $nombrePDF;
			$model->fecha_cierre = date("Y-m-d H:i:s");
			
			if ($model->save()) {
				$model->documento->saveAs(Yii::getPathOfAlias('webroot').'/upload/doc/'.$nombrePDF);
				//echo CHtml::script("parent.cerrarModal();");
				//echo CHtml::script("parent.location.reload();");
				$anio = Yii::app()->session['idPeriodoSelecionado'];
				echo CHtml::script('parent.window.location.href=parent.window.location.href+"?periodo='.$anio.'"');
                Yii::app()->end();
			}
					
		}//END-POST
		
			$this->layout = '//layouts/iframe';
			
			if (isset($etapa))
			{
				$nombreEtapa = $etapa->nombre;
				$whereCierresInternos = CierresInternos::model()->find("estado = 1 AND id_etapa =".$id." AND id_planificacion =".$idPlanificaciones);
				
				if(isset($whereCierresInternos->id)){
					$modelCierre = $this->loadModel($whereCierresInternos->id, 'CierresInternos');	
					
					$this->redirect('../update/'.$modelCierre->id);
					
				}else{
					$this->render('create', 
						array( 
						'model' => $model,
						'id_etapa'=>$id,
						'idPlanificaciones' => $idPlanificaciones,
						'nombreEtapa' => $nombreEtapa
						)
					);
				}
	
			}
	 
	}
	
	//Genera el cierre y ademas crea los PDF de formulario "H" y "A1"
	public function actionCreateCierre($id) {
		//$id = id_etapa;
		
		$model = new CierresInternos;

		//Buscamos el id del periodo
		$wherePeriodoProcesos = PeriodosProcesos::model()->find("id =".Yii::app()->session['idPeriodo']);
		//Buscamos la planificacion que está asociada al periodo actual seleccionado
		$wherePlanificaciones = Planificaciones::model()->find("estado = 1 AND periodo_proceso_id =".$wherePeriodoProcesos->id);
		//Asignamos el identificador de la planificaion del periodo actual
		
		$idPlanificaciones = $wherePlanificaciones->id;
		
		$etapa = Etapas::model()->find("id=".$id);
		$nombreEtapa = "";
		
		
		if (isset($_POST['CierresInternos'])) {
			
			$model->setAttributes($_POST['CierresInternos']);
			
			$model->documento=CUploadedFile::getInstance($model,'documento');
			
			$nombrePDF = str_replace(' ', '_', $model->documento);
			
			$nombrePDF = date("Y_m_d_H:i:s").$nombrePDF;
			
			$textoLimpio = preg_replace('([^A-Za-z0-9._])', '', $nombrePDF);
			
			$nombrePDF = $textoLimpio;
			
			$model->archivo = $nombrePDF;
			$model->fecha_cierre = date("Y-m-d H:i:s");
			
			
			//Generamos el formulario A1
			$model->formulario_a1= ReportesController::formA1exportfileServer();
			
			//Generamos el formulario H
			$model->formulario_h= ReportesController::formHexportfileServer();
			
			if ($model->save()) {
				$model->documento->saveAs(Yii::getPathOfAlias('webroot').'/upload/doc/'.$nombrePDF);
				//echo CHtml::script("parent.cerrarModal();");
				//echo CHtml::script("parent.location.reload();");
				$anio = Yii::app()->session['idPeriodoSelecionado'];
				echo CHtml::script('parent.window.location.href=parent.window.location.href+"?periodo='.$anio.'"');
                Yii::app()->end();
			}
					
		}//END-POST
		
			$this->layout = '//layouts/iframe';
			
			if (isset($etapa))
			{
			$nombreEtapa = $etapa->nombre;
					$this->render('create_cierre', 
						array( 
						'model' => $model,
						'id_etapa'=>$id,
						'idPlanificaciones' => $idPlanificaciones,
						'nombreEtapa' => $nombreEtapa
						)
					);
	
			}
	 
	}
	
    public function actionView($id) {
				$model = $this->loadModel($id, 'CierresInternos');
		$nombreEtapa = "";
		
		$this->layout = '//layouts/iframe';
		
		$idPlanificaciones=	$model->id_planificacion;
		$this->render('view', array(
				'model' => $model,
				'id_etapa'=>$id,
				'nombreEtapa' => $nombreEtapa,
				'idPlanificaciones' => $idPlanificaciones,
				));
				
	}
    public function actionViewCierre($id) {
				$model = $this->loadModel($id, 'CierresInternos');
		$nombreEtapa = "";
		
		$this->layout = '//layouts/iframe';
		
		$idPlanificaciones=	$model->id_planificacion;
		$this->render('viewCierre', array(
				'model' => $model,
				'id_etapa'=>$id,
				'nombreEtapa' => $nombreEtapa,
				'idPlanificaciones' => $idPlanificaciones,
				));
				
	}
	
	public function actionUpdate($id) {
		
		$model = $this->loadModel($id, 'CierresInternos');
		$nombreEtapa = "";
		
		
		
		if (isset($_POST['CierresInternos'])) {
			
			//echo "--->>".$_POST['CierresInternos']['documento'];
			
			$model->documento=CUploadedFile::getInstance($model,'documento');
			
			//if(!empty($_POST['CierresInternos']['documento']) )
			//Consultamos si es contiene un documento
			if(!empty($model->documento) )
			{
				
				$model->documento=CUploadedFile::getInstance($model,'documento');
				
				$nombrePDF = str_replace(' ', '_', $model->documento);
				$nombrePDF = date("Y_m_d_H:i:s").$nombrePDF;
				$textoLimpio = preg_replace('([^A-Za-z0-9._])', '', $nombrePDF);
				$nombrePDF = $textoLimpio;
				
				$model->archivo = $nombrePDF;
		
				//if($model->documento =! ' '){
					$model->documento->saveAs(Yii::getPathOfAlias('webroot').'/upload/doc/'.$nombrePDF);
				//}
			}else{
				$documento = Yii::getPathOfAlias('webroot').'/upload/doc/'.$model->archivo;
				
				if(file_exists($documento)){
					$model->documento = $model->archivo;
				}else{
					$model->archivo = "";
				} 
			 
	             if(!empty($model->archivo)){
						echo"Entre archivo";
						$model->documento = $model->archivo;
					}else{
						$model->archivo = "";
					}
				//echo $model->documento;

			}
			
			
			$model->observaciones = $_POST['CierresInternos']['observaciones'];
			$model->id_usuario = Yii::app()->user->id;
			$model->fecha_cierre = date("Y-m-d H:i:s");
	
			
			//echo "antes";
			if ($model->update()) {
				echo CHtml::script("parent.cerrarModal();");
			}
			echo CHtml::script("parent.cerrarModal();");
		}
		$this->layout = '//layouts/iframe';
		
		$idPlanificaciones=	$model->id_planificacion;
		$this->render('update', array(
				'model' => $model,
				'id_etapa'=>$id,
				'nombreEtapa' => $nombreEtapa,
				'idPlanificaciones' => $idPlanificaciones,
				));
	}
	
	public function actionUpdateCierre($id) {
		
		$model = $this->loadModel($id, 'CierresInternos');
		$nombreEtapa = "";
		
		
		
		if (isset($_POST['CierresInternos'])) {
			
			//echo "--->>".$_POST['CierresInternos']['documento'];
			
			$model->documento=CUploadedFile::getInstance($model,'documento');
			
			//if(!empty($_POST['CierresInternos']['documento']) )
			//Consultamos si es contiene un documento
			if(!empty($model->documento) )
			{
				
				$model->documento=CUploadedFile::getInstance($model,'documento');
				
				$nombrePDF = str_replace(' ', '_', $model->documento);
				$nombrePDF = date("Y_m_d_H:i:s").$nombrePDF;
				$textoLimpio = preg_replace('([^A-Za-z0-9._])', '', $nombrePDF);
				$nombrePDF = $textoLimpio;
				
				$model->archivo = $nombrePDF;
		
				//if($model->documento =! ' '){
					$model->documento->saveAs(Yii::getPathOfAlias('webroot').'/upload/doc/'.$nombrePDF);
				//}
			}else{
				$documento = Yii::getPathOfAlias('webroot').'/upload/doc/'.$model->archivo;
				
				if(file_exists($documento)){
					$model->documento = $model->archivo;
				}else{
					$model->archivo = "";
				}

				if(!empty($model->archivo)){
						echo"Entre archivo";
						$model->documento = $model->archivo;
				}else{
						$model->archivo = "";
				}
				//echo $model->documento;
				
			}
			
				//Generamos el formulario A1
			$model->formulario_a1= ReportesController::formA1exportfileServer();
			
			//Generamos el formulario H
			$model->formulario_h= ReportesController::formHexportfileServer();
			$model->observaciones = $_POST['CierresInternos']['observaciones'];
			$model->id_usuario = Yii::app()->user->id;
			$model->fecha_cierre = date("Y-m-d H:i:s");
	
			
			//echo "antes";
			if ($model->update()) {
				echo CHtml::script("parent.cerrarModal();");
			}
			echo CHtml::script("parent.cerrarModal();");
		}
		$this->layout = '//layouts/iframe';
		
		$idPlanificaciones=	$model->id_planificacion;
		$this->render('updateCierre', array(
				'model' => $model,
				'id_etapa'=>$id,
				'nombreEtapa' => $nombreEtapa,
				'idPlanificaciones' => $idPlanificaciones,
				));
	}



	
	public function actionBorrar($id){
		//$valor = $_GET["valor"];
		//$id = $_GET["id"];
		$model = $this->loadModel($id, 'CierresInternos');
		
		$documento = Yii::getPathOfAlias('webroot').'/upload/doc/'.$model->archivo;

		$resultado = false;
		//Eliminando Archivo 
		if(file_exists($documento)){
			//echo "encontrado";
			unlink($documento);
			
			$model->archivo = "";
			$model->update();
			$resultado = true;
			
		} 
		
		
		header("Content-type: application/json");	
		echo CJSON::encode($resultado);
	}
	
	public function actionCierreInterno($id)
	{
		//Buscamos el id del periodo
		$wherePeriodoProcesos = PeriodosProcesos::model()->find("id =".Yii::app()->session['idPeriodo']);
		//Buscamos la planificacion que está asociada al periodo actual seleccionado
		$wherePlanificaciones = Planificaciones::model()->find("estado = 1 AND periodo_proceso_id =".$wherePeriodoProcesos->id);
		//Asignamos el identificador de la planificaion del periodo actual
		
		$idPlanificaciones = $wherePlanificaciones->id;
		
		
		$whereCierresInternos = CierresInternos::model()->find("estado = 1 AND id_etapa =".$id." AND id_planificacion =".$idPlanificaciones);
		$admin=Yii::app()->user->checkAccessChange(array('modelName'=>'CierresInternos','fieldName'=>'id_usuario','idRow'=>Yii::app()->user->id));
		
		if(isset($whereCierresInternos->id)){
			$modelCierre = $this->loadModel($whereCierresInternos->id, 'CierresInternos');	

			if($admin){ 
				if(($id=='3') || ($id=='4') ){
					$this->redirect('../updateCierre/'.$modelCierre->id);
				}else {
					$this->redirect('../update/'.$modelCierre->id);
				}
			}else{
				if(($id=='3') || ($id=='4')){
					$this->redirect('../viewCierre/'.$modelCierre->id);
				}else{
					$this->redirect('../view/'.$modelCierre->id);
				}
			}
			
					
		}else{
			if($admin){ 
				if(($id=='3') || ($id=='4')){
					$this->redirect('../createCierre/'.$id);
				}else{
					$this->redirect('../create/'.$id);
				}
				
			}else{

				echo CHtml::script("parent.cerrarModal();");
				/*echo CHtml::script("
					parent.$('#cboxContent').height(100);
					parent.$('#cboxContent').width(300);
				");*/
				
				echo CHtml::script("parent.jAlert('No se encuentran datos para visualizar!!','Mensaje'); ");
				
				  /*echo '<html><div class="form" id="content"> 
					No se encuentran datos para visualizar!!
					  </div></html>';
			*/
			}	
		}
		
	}
	
	public function actionCierreEtapa($id){
		$model = $this->loadModel($id, 'CierresInternos');
		$model->id_usuario = Yii::app()->user->id;
		$model->fecha_cierre = date("Y-m-d H:i:s");
		$model->cierre_etapa = '1';	
		//Generamos el formulario A1
		$model->formulario_a1= ReportesController::formA1exportfileServer();	
		//Generamos el formulario H
		$model->formulario_h= ReportesController::formHexportfileServer();
		
		$cierre=FALSE;
		if ($model->update()) {
			$cierre=TRUE;
		}
		
		//header("Content-type: application/json");
		echo CJSON::encode(array('cierre'=>$cierre));

	}
	
	
}