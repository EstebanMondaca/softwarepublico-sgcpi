<?php

class ObjetivosEstrategicosController extends GxController {

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
                'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
            ),
            array('allow',
                'actions'=>array('update','create','delete'),
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
     
	public function actionView($id) {
	    $this->layout = '//layouts/iframe';
		$this->render('view', array(
			'model' => $this->loadModel($id, 'ObjetivosEstrategicos'),
		));
	}

	public function actionCreate() {
		$model = new ObjetivosEstrategicos;


		if (isset($_POST['ObjetivosEstrategicos'])) {
			$model->setAttributes($_POST['ObjetivosEstrategicos']);
			$relatedData = array(
				'desafiosEstrategicoses' => $_POST['ObjetivosEstrategicos']['desafiosEstrategicoses'] === '' ? null : $_POST['ObjetivosEstrategicos']['desafiosEstrategicoses'],
				'objetivosMinisteriales' => $_POST['ObjetivosEstrategicos']['objetivosMinisteriales'] === '' ? null : $_POST['ObjetivosEstrategicos']['objetivosMinisteriales'],
				//'productosEstrategicoses' => $_POST['ObjetivosEstrategicos']['productosEstrategicoses'] === '' ? null : $_POST['ObjetivosEstrategicos']['productosEstrategicoses'],
				);

			if ($model->saveWithRelated($relatedData)) {
			    echo CHtml::script("parent.cerrarModal();");
                Yii::app()->end();					
			}
		}
        $this->layout = '//layouts/iframe';
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'ObjetivosEstrategicos');


		if (isset($_POST['ObjetivosEstrategicos'])) {
			$model->setAttributes($_POST['ObjetivosEstrategicos']);
			$relatedData = array(
				'desafiosEstrategicoses' => $_POST['ObjetivosEstrategicos']['desafiosEstrategicoses'] === '' ? null : $_POST['ObjetivosEstrategicos']['desafiosEstrategicoses'],
				'objetivosMinisteriales' => $_POST['ObjetivosEstrategicos']['objetivosMinisteriales'] === '' ? null : $_POST['ObjetivosEstrategicos']['objetivosMinisteriales'],
				//'productosEstrategicoses' => $_POST['ObjetivosEstrategicos']['productosEstrategicoses'] === '' ? null : $_POST['ObjetivosEstrategicos']['productosEstrategicoses'],
				);

			if ($model->saveWithRelated($relatedData)) {
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
			$this->loadModel($id, 'ObjetivosEstrategicos')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                //$this->redirect(array('index'));
			}
				
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new ObjetivosEstrategicos('search');
        $model->unsetAttributes();

        if (isset($_GET['ObjetivosEstrategicos']))
            $model->setAttributes($_GET['ObjetivosEstrategicos']);

        $this->render('index', array(
            'model' => $model,
        ));
	}

	/*public function actionAdmin() {
		$model = new ObjetivosEstrategicos('search');
		$model->unsetAttributes();

		if (isset($_GET['ObjetivosEstrategicos']))
			$model->setAttributes($_GET['ObjetivosEstrategicos']);

		$this->render('index', array(
			'model' => $model,
		));
	}*/

}