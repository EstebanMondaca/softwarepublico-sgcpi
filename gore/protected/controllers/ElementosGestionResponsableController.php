<?php

class ElementosGestionResponsableController extends GxController {
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
            /*array('allow',
                'actions'=>array('index','view'),                
                'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
            ),*/
            array('allow',
                'actions'=>array('update','create'),
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

	/*public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'ElementosGestionResponsable'),
		));
	}*/

	public function actionCreate($id) {
		$model = new ElementosGestionResponsable;


		if (isset($_POST['ElementosGestionResponsable'])) {
			$model->setAttributes($_POST['ElementosGestionResponsable']);

			if ($model->save()) {
					echo CHtml::script("parent.actualizarElementosDeGestionConResponsables();");
                    Yii::app()->end();
			}
		}
        $this->layout = '//layouts/iframe';
		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'ElementosGestionResponsable');
		if (isset($_POST['ElementosGestionResponsable'])) {
			$model->setAttributes($_POST['ElementosGestionResponsable']);
			if ($model->save()) {
				echo CHtml::script("parent.actualizarElementosDeGestionConResponsables();");
                Yii::app()->end();
			}
		}
        $this->layout = '//layouts/iframe';
		$this->render('update', array(
				'model' => $model,
				));
	}

	/*public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'ElementosGestionResponsable')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}*/

	/*public function actionIndex() {
		$model = new ElementosGestionResponsable('search');
        $model->unsetAttributes();

        if (isset($_GET['ElementosGestionResponsable']))
            $model->setAttributes($_GET['ElementosGestionResponsable']);

        $this->render('index', array(
            'model' => $model,
        ));
	}*/

	

}