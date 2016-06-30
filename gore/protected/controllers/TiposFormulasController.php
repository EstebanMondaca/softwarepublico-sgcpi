<?php

class TiposFormulasController extends GxController {
    
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
		$model = new TiposFormulas('search');
		$model->unsetAttributes();

		if (isset($_GET['TiposFormulas']))
			$model->setAttributes($_GET['TiposFormulas']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new TiposFormulas;


		if (isset($_POST['TiposFormulas'])) {
			$model->setAttributes($_POST['TiposFormulas']);

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
		$model = $this->loadModel($id, 'TiposFormulas');


		if (isset($_POST['TiposFormulas'])) {
			$model->setAttributes($_POST['TiposFormulas']);

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
			$this->loadModel($id, 'TiposFormulas')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new TiposFormulas('search');
		$model->unsetAttributes();

		if (isset($_GET['TiposFormulas']))
			$model->setAttributes($_GET['TiposFormulas']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new TiposFormulas('search');
		$model->unsetAttributes();

		if (isset($_GET['TiposFormulas']))
			$model->setAttributes($_GET['TiposFormulas']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	protected function gridDataBreakText($data,$raw) {
	
		$string =  $data->nombre;
	
		$phrase_array = explode(' ',$data->nombre);
	
		if(count($phrase_array) < 30 ){
			if(strlen($string) > 100) {
	
				$string = substr($string, 0, 95);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}

}