<?php

class ItemesPresupuestariosController extends GxController {

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
		$model = new ItemesPresupuestarios('search');
		$model->unsetAttributes();

		if (isset($_GET['ItemesPresupuestarios']))
			$model->setAttributes($_GET['ItemesPresupuestarios']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new ItemesPresupuestarios;


		if (isset($_POST['ItemesPresupuestarios'])) {
			$model->setAttributes($_POST['ItemesPresupuestarios']);
			$relatedData = array(
				//'actividades' => $_POST['ItemesPresupuestarios']['actividades'] === '' ? null : $_POST['ItemesPresupuestarios']['actividades'],
				//'productosEstrategicoses' => $_POST['ItemesPresupuestarios']['productosEstrategicoses'] === '' ? null : $_POST['ItemesPresupuestarios']['productosEstrategicoses'],
				);

			if ($model->saveWithRelated($relatedData)) {
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
		$model = $this->loadModel($id, 'ItemesPresupuestarios');


		if (isset($_POST['ItemesPresupuestarios'])) {
			$model->setAttributes($_POST['ItemesPresupuestarios']);
			$relatedData = array(
				//'actividades' => $_POST['ItemesPresupuestarios']['actividades'] === '' ? null : $_POST['ItemesPresupuestarios']['actividades'],
				//'productosEstrategicoses' => $_POST['ItemesPresupuestarios']['productosEstrategicoses'] === '' ? null : $_POST['ItemesPresupuestarios']['productosEstrategicoses'],
				);

			if ($model->saveWithRelated($relatedData)) {
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
			$this->loadModel($id, 'ItemesPresupuestarios')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new ItemesPresupuestarios('search');
		$model->unsetAttributes();

		if (isset($_GET['ItemesPresupuestarios']))
			$model->setAttributes($_GET['ItemesPresupuestarios']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new ItemesPresupuestarios('search');
		$model->unsetAttributes();

		if (isset($_GET['ItemesPresupuestarios']))
			$model->setAttributes($_GET['ItemesPresupuestarios']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	protected function gridDataBreakText($data,$raw) {
	
		$string =  $data->nombre;
	
		$phrase_array = explode(' ',$data->nombre);
	
		if(count($phrase_array) < 30 ){
			if(strlen($string) > 70) {
	
				$string = substr($string, 0, 65);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}

}