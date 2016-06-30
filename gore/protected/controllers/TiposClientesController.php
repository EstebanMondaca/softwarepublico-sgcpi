<?php

class TiposClientesController extends GxController {

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
		$model = new TiposClientes('search');
		$model->unsetAttributes();

		if (isset($_GET['TiposClientes']))
			$model->setAttributes($_GET['TiposClientes']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new TiposClientes;


		if (isset($_POST['TiposClientes'])) {
			$model->setAttributes($_POST['TiposClientes']);

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
		$model = $this->loadModel($id, 'TiposClientes');


		if (isset($_POST['TiposClientes'])) {
			$model->setAttributes($_POST['TiposClientes']);

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
			$this->loadModel($id, 'TiposClientes')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new TiposClientes('search');
		$model->unsetAttributes();

		if (isset($_GET['TiposClientes']))
			$model->setAttributes($_GET['TiposClientes']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new TiposClientes('search');
		$model->unsetAttributes();

		if (isset($_GET['TiposClientes']))
			$model->setAttributes($_GET['TiposClientes']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}