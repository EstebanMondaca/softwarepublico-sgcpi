<?php

class EstadosPlanificacionesController extends GxController {

    public function filters()
    {
        return array(
            'accessControl', 
        );
    }
    
    public function accessRules() {
          return array(
            array('allow',
                'actions'=>array('update','create'),
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'EstadosPlanificaciones'),
		));
	}

	public function actionCreate() {
		$model = new EstadosPlanificaciones;

		$this->performAjaxValidation($model, 'estados-planificaciones-form');

		if (isset($_POST['EstadosPlanificaciones'])) {
			$model->setAttributes($_POST['EstadosPlanificaciones']);

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
		$model = $this->loadModel($id, 'EstadosPlanificaciones');

		$this->performAjaxValidation($model, 'estados-planificaciones-form');

		if (isset($_POST['EstadosPlanificaciones'])) {
			$model->setAttributes($_POST['EstadosPlanificaciones']);

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
			$this->loadModel($id, 'EstadosPlanificaciones')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('EstadosPlanificaciones');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new EstadosPlanificaciones('search');
		$model->unsetAttributes();

		if (isset($_GET['EstadosPlanificaciones']))
			$model->setAttributes($_GET['EstadosPlanificaciones']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}