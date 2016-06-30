<?php

class ActivacionProcesoController extends GxController {

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
                'actions'=>array('index','update'),                
                'roles'=>array('admin'),
           	),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    
	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'ActivacionProceso');

		$this->performAjaxValidation($model, 'activacion-proceso-form');

		if (isset($_POST['ActivacionProceso'])) {
			$model->setAttributes($_POST['ActivacionProceso']);

			if ($model->save()) {
				echo CHtml::script("parent.cerrarModal();");
				//$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$this->layout = '//layouts/iframe';
		$this->render('update', array(
				'model' => $model,
				));
	}

	
	public function actionIndex() {
	//public function actionAdmin() {
		$model = new ActivacionProceso('search');
		$model->unsetAttributes();

		if (isset($_GET['ActivacionProceso']))
			$model->setAttributes($_GET['ActivacionProceso']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}