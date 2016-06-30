<?php

class ProductosEspecificosController extends GxController {

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    
    public function accessRules() {
          return array(
            array('allow',
                'actions'=>array('index','view'),                
                'roles'=>array('admin'),
            ),
            array('allow',
                'actions'=>array('update','create','delete','admin'), //'minicreate', 'create', 'update', 'admin', 'delete'
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    } 
	public function actionView($id) {
		$model = new ProductosEspecificos('search');
        $model->unsetAttributes();
        $this->render('index', array(
            'model' => $model,
        ));
	}

	public function actionCreate() {
		$model = new ProductosEspecificos;

		if (isset($_POST['ProductosEspecificos'])) {
			$model->setAttributes($_POST['ProductosEspecificos']);

			if ($model->save()) {
				/*if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('index', 'id' => $model->id));*/
				echo CHtml::script("parent.cerrarPanelIframe();");
			}
		}
        $this->layout = '//layouts/iframe';
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'ProductosEspecificos');


		if (isset($_POST['ProductosEspecificos'])) {
			$model->setAttributes($_POST['ProductosEspecificos']);

			if ($model->save()) {
			    echo CHtml::script("parent.cerrarPanelIframe();");
				//$this->redirect(array('index', 'id' => $model->id));
			}
		}
        $this->layout = '//layouts/iframe';
		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'ProductosEspecificos')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest()){
			    //$this->redirect(array('index'));
			    echo CHtml::script("parent.cerrarPanelIframe();");
			}
				
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new ProductosEspecificos('search');
        $model->unsetAttributes();

        if (isset($_GET['ProductosEspecificos']))
            $model->setAttributes($_GET['ProductosEspecificos']);

        $this->render('index', array(
            'model' => $model,
        ));
	}
}