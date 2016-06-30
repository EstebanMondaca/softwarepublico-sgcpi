<?php

class PlanificacionesController extends GxController {
    
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
			'model' => $this->loadModel($id, 'Planificaciones'),
		));
	}

	public function actionCreate() {
		$model = new Planificaciones;

		$this->performAjaxValidation($model, 'planificaciones-form');

		if (isset($_POST['Planificaciones'])) {
			$model->setAttributes($_POST['Planificaciones']);

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
		$model = $this->loadModel($id, 'Planificaciones');

		$this->performAjaxValidation($model, 'planificaciones-form');

		if (isset($_POST['Planificaciones'])) {
			$model->setAttributes($_POST['Planificaciones']);

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
			$this->loadModel($id, 'Planificaciones')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Planificaciones');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Planificaciones('search');
		$model->unsetAttributes();

		if (isset($_GET['Planificaciones']))
			$model->setAttributes($_GET['Planificaciones']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}