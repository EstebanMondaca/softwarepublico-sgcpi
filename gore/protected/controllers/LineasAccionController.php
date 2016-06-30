<?php

class LineasAccionController extends GxController {
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
                'actions'=>array('index','view','cargarCentroCosto','create'),                
                'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
            ),
            array('allow',
                'actions'=>array('update','delete'),
                //'roles'=>array('admin'),
                'expression'=>"(Yii::app()->user->checkAccessChange(array('modelName'=>'LineasAccion','fieldName'=>'id_responsable_mantencion','idRow'=>Yii::app()->getRequest()->getQuery('id'))))||(Yii::app()->user->checkAccessChange(array('modelName'=>'LineasAccion','fieldName'=>'id_responsable_implementacion','idRow'=>Yii::app()->getRequest()->getQuery('id'))))", 
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionView($id) {
        $modelLA = new LaElemGestion('searchLineasAccion');
        $modelLA->unsetAttributes();
        $modelLA->id_la=$id;
        $this->render('view', array(
            'model' => $this->loadModel($id, 'LineasAccion'),
            'modelLA'=>$modelLA
        ));
    } 

	public function actionCreate() {
		$model = new LineasAccion;
        //Validando con Ajax
        $this->performAjaxValidation($model, 'lineas-accion-form');
        
		if (isset($_POST['LineasAccion'])) {
			$model->setAttributes($_POST['LineasAccion']);
			$relatedData = array(
				'users' => $_POST['LineasAccion']['users'] === '' ? null : $_POST['LineasAccion']['users'],
				);

			if ($model->saveWithRelated($relatedData)) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('update', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'LineasAccion');
        
        $modelLA = new LaElemGestion('searchLineasAccion');
        $modelLA->unsetAttributes();
        $modelLA->id_la=$id;
        
        //Validando con Ajax
        $this->performAjaxValidation($model, 'lineas-accion-form');
        $validateInsert=true;
		if (isset($_POST['LineasAccion'])) {
			$model->setAttributes($_POST['LineasAccion']);
			$relatedData = array(
				'users' => $_POST['LineasAccion']['users'] === '' ? null : $_POST['LineasAccion']['users'],
		    );            
            //Almacenando LA de elementos de gestión
            $LaElemGestion = (isset($_POST['LaElemGestion']))?$_POST['LaElemGestion']:null;
            if(count($LaElemGestion)>0)
            {
                $idPeriodo=Planificaciones::model()->findAll(array('select'=>'t.id','join'=>'INNER JOIN periodos_procesos pp on pp.id=t.periodo_proceso_id','condition'=>'t.estado=1 AND pp.id='.Yii::app()->session['idPeriodo']));
                foreach($LaElemGestion as $rowId=>$fielId)
                {
                    if(!isset($fielId['delete'])){
                        //LaElemGestion[$row][puntaje_esperado][$data->id]
                        foreach($fielId['puntaje_esperado'] as $k=>$v)
                        {
                            if($k!=""){//Debemos actualizar el valor
                                $model_la=$this->loadModel($k, 'LaElemGestion');
                                $model_la->puntaje_esperado = $v;
                                $model_la->save();
                              }else{//Debemos insertarlo
                                $model_la=new LaElemGestion;
                                $model_la->id_la=$id;
                                $model_la->id_elem_gestion=$fielId['id_elem_gestion'];
                                $model_la->id_planificacion=$idPeriodo[0]->id;
                                $model_la->puntaje_esperado = $v;
                                if($model_la->validate()){
                                    $model_la->save();
                                }else{
                                    $validateInsert=false;
                                }                                                                    
                            }
                        }                   
                    }else{
                        //Debemos eliminar el valor
                        $this->loadModel($fielId['delete'], 'LaElemGestion')->delete();
                    }
                    
                }
            }
            //fin Almacenando LA de elementos de gestión            
			if ($model->saveWithRelated($relatedData)) {
				//$this->redirect(array('index'));
			}
            
            
		}
        
        $this->render('update', array(
            'model' => $model,
            'modelLA'=>$modelLA
        ));
		
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			
			$nuevoModelo= $this->loadModel($id, 'LineasAccion');
			//Modifica el estado a la linea de accion

			$this->loadModel($id, 'LineasAccion')->delete();
			
			//Modifica el estado del indicador asociado a la AMI
			/*$modelIndicadores= Indicadores::model()->find("id=".$nuevoModelo->id_indicador);
          	$modelIndicadores->estado = 0;
            $modelIndicadores->update();*/
                            

			
			//print_r($nuevoModelo->id_indicador);

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}
    
   	public function actionIndex() {
		$model = new LineasAccion('search');
        $model->unsetAttributes();
        if (isset($_GET['LineasAccion']))
            $model->setAttributes($_GET['LineasAccion']);
        $this->render('index', array(
            'model' => $model,
        ));
	}

	public function actionAdmin() {
		$model = new LineasAccion('search');
		$model->unsetAttributes();

		if (isset($_GET['LineasAccion']))
			$model->setAttributes($_GET['LineasAccion']);

		$this->render('index', array(
			'model' => $model,
		));
	}
    
    //Funcion utilizada para cargar los centros de costo desde un producto estrategico.
    public function actionCargarCentroCosto()
    {       
        $data = CentrosCostos::model()->findAll(array('condition'=>'pe.id='.$_POST['LineasAccion']['producto_estrategico_id'],'join'=>'inner join productos_estrategicos pe on t.division_id=pe.division_id INNER JOIN users_centros ucc ON ucc.centro_id=t.id AND ucc.user_id='.$_POST['LineasAccion']['id_responsable_implementacion']));    
        $data = CHtml::listData($data,'id','nombre');
        foreach($data as $id => $value){
            echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
        }
    }
    

}