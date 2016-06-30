<?php

class ViaticosController extends GxController {
	
	public function filters() {
		return array(
				'accessControl',
		);
	}
	public function accessRules() {
		return array(
				array('allow',
						'actions'=>array('update','create','delete','admin','index','view'),
						'roles'=>array('admin'),
				),
				array('deny',
						'users'=>array('*'),
				),
		);
	}
	
	public function actionView($id) {
		$model = new Viaticos('search');
		$model->unsetAttributes();

		if (isset($_GET['Viaticos']))
			$model->setAttributes($_GET['Viaticos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new Viaticos;


		if (isset($_POST['Viaticos'])) {
			$model->setAttributes($_POST['Viaticos']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else{
					//$this->redirect(array('view', 'id' => $model->id));
					echo CHtml::script("parent.cerrarModal();");
					Yii::app()->end();
				}
			}
		}

		$this->layout = '//layouts/iframe';
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Viaticos');


		if (isset($_POST['Viaticos'])) {
			$model->setAttributes($_POST['Viaticos']);

			if ($model->save()) {
				//$this->redirect(array('view', 'id' => $model->id));
				echo CHtml::script("parent.cerrarModal();");
				Yii::app()->end();
			}
		}

		$this->layout = '//layouts/iframe';
		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Viaticos')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}


	public function actionIndex() {
		$model = new Viaticos('search');
		$model->unsetAttributes();

		if (isset($_GET['Viaticos']))
			$model->setAttributes($_GET['Viaticos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new Viaticos('search');
		$model->unsetAttributes();

		if (isset($_GET['Viaticos']))
			$model->setAttributes($_GET['Viaticos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}