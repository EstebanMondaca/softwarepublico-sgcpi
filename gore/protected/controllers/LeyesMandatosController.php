<?php

class LeyesMandatosController extends GxController {

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
		$model = new LeyesMandatos('search');
		$model->unsetAttributes();

		if (isset($_GET['LeyesMandatos']))
			$model->setAttributes($_GET['LeyesMandatos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new LeyesMandatos;


		if (isset($_POST['LeyesMandatos'])) {
			$model->setAttributes($_POST['LeyesMandatos']);

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
		$model = $this->loadModel($id, 'LeyesMandatos');


		if (isset($_POST['LeyesMandatos'])) {
			$model->setAttributes($_POST['LeyesMandatos']);

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
			$this->loadModel($id, 'LeyesMandatos')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new LeyesMandatos('search');
		$model->unsetAttributes();

		if (isset($_GET['LeyesMandatos']))
			$model->setAttributes($_GET['LeyesMandatos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new LeyesMandatos('search');
		$model->unsetAttributes();

		if (isset($_GET['LeyesMandatos']))
			$model->setAttributes($_GET['LeyesMandatos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	protected function gridDataBreakText($data,$raw) {
	
		$string =  $data->nombre;
	
		$phrase_array = explode(' ',$data->nombre);
	
		if(count($phrase_array) < 30 ){
			if(strlen($string) > 35) {
	
				$string = substr($string, 0, 30);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}
	
	protected function gridDataBreakText2($data,$raw) {
	
		$string =  $data->descripcion;
	
		$phrase_array = explode(' ',$data->descripcion);
	
		if(count($phrase_array) > 0){
			if(strlen($string) > 65) {
	
				$string = substr($string, 0, 60);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}
	
	protected function gridDataBreakText3($data,$raw) {
	
		$string =  $data->url;
	
		$phrase_array = explode(' ',$data->url);
	
		if(count($phrase_array) < 2 ){
			if(strlen($string) > 35) {
	
				$string = substr($string, 0, 30);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}

}