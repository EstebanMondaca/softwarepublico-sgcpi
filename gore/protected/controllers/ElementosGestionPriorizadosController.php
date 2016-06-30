<?php

class ElementosGestionPriorizadosController extends GxController {

    
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', 
        );
    }
    
    public function accessRules() {
          return array(
            array('allow',
                'actions'=>array('index','view','obtenerSubCriterios','obtenerElementosDeGestion'),                
                'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
            ),
            array('allow',
                'actions'=>array('update','create','delete'),
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
    
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'ElementosGestionPriorizados'),
		));
	}

	public function actionCreate($id) {
		//id = id_elemento_gestion
		//id_planificacion
		
		//Buscamos el id del periodo
		$wherePeriodoProcesos = PeriodosProcesos::model()->find("id =".Yii::app()->session['idPeriodo']);
		//Buscamos la planificacion que está asociada al periodo actual seleccionado
		$wherePlanificaciones = Planificaciones::model()->find("estado = 1 AND periodo_proceso_id =".$wherePeriodoProcesos->id);
		
		//echo $wherePlanificaciones->id;
		
		
		
		$whereElementoID = ElementosGestionPriorizados::model()->find("estado = 1 AND id_elemento_gestion =".$id);
		
		$resultado=false;
		//echo $whereElementoID->id_elemento_gestion;
		if(!isset($whereElementoID->id_elemento_gestion)){
			
			
			 $modelElementos= new ElementosGestionPriorizados;
			    				
			 $modelElementos->id_elemento_gestion=$id;
			 $modelElementos->id_planificacion=$wherePlanificaciones->id;
	
			 if($modelElementos->save())
			 {
			 	$resultado=true;		 
			 }
		}
		
		    				
		    				
		
		header("Content-type: application/json");
		echo CJSON::encode($resultado);
		
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'ElementosGestionPriorizados');


		if (isset($_POST['ElementosGestionPriorizados'])) {
			$model->setAttributes($_POST['ElementosGestionPriorizados']);

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
			$this->loadModel($id, 'ElementosGestionPriorizados')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		/*$dataProvider = new CActiveDataProvider('ElementosGestionPriorizados');
		$this->render('admin', array(
			'dataProvider' => $dataProvider,
		));*/
		
		//Traemos todos los criterios 
		$criterios = Criterios::model()->findAll(array('condition'=>'estado = 1'));
		
		$model = new ElementosGestionPriorizados('search');
		$model->unsetAttributes();
        
        $modelElementosGestion = new ElementosGestion('search');
        $modelElementosGestion->unsetAttributes();

		if (isset($_GET['ElementosGestionPriorizados']))
			$model->setAttributes($_GET['ElementosGestionPriorizados']);

		$this->render('admin', array(
			'model' => $model,
			'modelElementosGestion'=>$modelElementosGestion,
			'criterios' => $criterios,
		));
		
	}

	public function actionAdmin() {
		$model = new ElementosGestionPriorizados('search');
		$model->unsetAttributes();

		if (isset($_GET['ElementosGestionPriorizados']))
			$model->setAttributes($_GET['ElementosGestionPriorizados']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	/*****************************************************************************
	 * actionObtenerSubCriterios
	 * --------------------------
	 * 
	 ****************************************************************************/
	public function actionObtenerSubCriterios($id){
		
		$subCriterios = Subcriterios::model()->findAll(array('condition'=>'id_criterio = '.$id.' AND estado = 1') );

		header("Content-type: application/json");
		echo CJSON::encode($subCriterios);
	}
	/*****************************************************************************
	 * actionObtenerElementosDeGestion
	 * --------------------------
	 * 
	 ****************************************************************************/
		public function actionObtenerElementosDeGestion($id){
		
		$elementosDeGestion = ElementosGestion::model()->findAll(array('condition'=>'id_subcriterio = '.$id.' AND estado = 1') );

		header("Content-type: application/json");
		echo CJSON::encode($elementosDeGestion);
	}

}