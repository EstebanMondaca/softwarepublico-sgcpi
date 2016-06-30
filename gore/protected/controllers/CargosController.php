<?php

class CargosController extends GxController {
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
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Cargos'),
		));
	}

	public function actionCreate() {
		$model = new Cargos;

		if (isset($_POST['Cargos'])) {
			$model->setAttributes($_POST['Cargos']);

			if ($model->save()) {
				echo CHtml::script("parent.cerrarModal();");
                Yii::app()->end();
			}
		}
        $this->layout = '//layouts/iframe';
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Cargos');


		if (isset($_POST['Cargos'])) {
			$model->setAttributes($_POST['Cargos']);

			if ($model->save()) {
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
			$this->loadModel($id, 'Cargos')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new Cargos('search');
        $model->unsetAttributes();

        if (isset($_GET['Cargos']))
            $model->setAttributes($_GET['Cargos']);

        $this->render('index', array(
            'model' => $model,
        ));
	}

	/*public function actionAdmin() {
		$model = new Cargos('search');
		$model->unsetAttributes();

		if (isset($_GET['Cargos']))
			$model->setAttributes($_GET['Cargos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}*/

}