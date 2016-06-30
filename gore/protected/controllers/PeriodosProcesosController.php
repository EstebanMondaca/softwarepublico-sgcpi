<?php

class PeriodosProcesosController extends GxController {

    public function filters() {
    return array(
            'accessControl', 
            );
    }
    
    public function accessRules() {                  
          return array(                     
            array('deny',
                'users'=>array('*'),
            ),
        );
    }  
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'PeriodosProcesos'),
		));
	}

	public function actionCreate() {
		$model = new PeriodosProcesos;

		$this->performAjaxValidation($model, 'periodos-procesos-form');

		if (isset($_POST['PeriodosProcesos'])) {
			$model->setAttributes($_POST['PeriodosProcesos']);

			if ($model->save()) {
			 // if (!empty($_GET['asDialog'])){
			  	echo CHtml::script("parent.cerrarModal();");
			  	
				if (Yii::app()->getRequest()->getIsAjaxRequest())
				{	
					Yii::app()->end();
				}
			 /* }else{
					$this->redirect(array('index', 'id' => $model->id));
			  }*/
			}
		}
			
		
		//if (!empty($_GET['asDialog']))
            $this->layout = '//layouts/iframe';
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'PeriodosProcesos');

		//$this->performAjaxValidation($model, 'periodos-procesos-form');

		if (isset($_POST['PeriodosProcesos'])) {
			$model->setAttributes($_POST['PeriodosProcesos']);

			if($model->save()){
			    //if (!empty($_GET['asDialog'])){
 					echo CHtml::script("parent.cerrarModal();");
                    Yii::app()->end();
               //}else               
				//    $this->redirect(array('index', 'id' => $model->id));
			}
		}
	//	if (!empty($_GET['asDialog']))
            $this->layout = '//layouts/iframe';
            
		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'PeriodosProcesos')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('PeriodosProcesos');
		$model = new PeriodosProcesos('search');
		$model->unsetAttributes();
		
		if (isset($_GET['PeriodosProcesos']))
			$model->setAttributes($_GET['PeriodosProcesos']);
			
		$this->render('index', array(
			'dataProvider' => $dataProvider,
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new PeriodosProcesos('search');
		$model->unsetAttributes();

		if (isset($_GET['PeriodosProcesos']))
			$model->setAttributes($_GET['PeriodosProcesos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	public function actionSeleccionar() {
		$model = new PeriodosProcesos('search');
		$model->unsetAttributes();

		if (isset($_GET['PeriodosProcesos']))
			$model->setAttributes($_GET['PeriodosProcesos']);

		$this->render('seleccionar', array(
			'model' => $model,
		));
	}

}