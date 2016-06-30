<?php

class DivisionesController extends GxController {

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
		$model = new Divisiones('search');
		$model->unsetAttributes();
	
		$divisiones = Divisiones::model()->findAll(array('condition'=>'estado = 1'));
		
		if (isset($_GET['Divisiones']))
			$model->setAttributes($_GET['Divisiones']);

		$this->render('admin', array(
				'divisiones' => $divisiones,
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new Divisiones;


		if (isset($_POST['Divisiones'])) {
			$model->setAttributes($_POST['Divisiones']);

			if ($model->save()) {
				echo CHtml::script("parent.cerrarModal();");
                Yii::app()->end();
			}
		}
		$this->layout = '//layouts/iframe';
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Divisiones');


		if (isset($_POST['Divisiones'])) {
			$model->setAttributes($_POST['Divisiones']);

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
			$this->loadModel($id, 'Divisiones')->delete();
			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
	    
		$model = new Divisiones('search');
		$model->unsetAttributes();
		
		$divisiones = Divisiones::model()->findAll(array('condition'=>'estado = 1'));
		
		
		if (isset($_GET['Divisiones'])){
			$model->setAttributes($_GET['Divisiones']);
		}
		//$this->render('admin', array(
		//	'model' => $model,
		$this->render('admin', array(
				'divisiones' => $divisiones,
				'model' => $model,
				));
		
		
	}

	public function actionAdmin() {
		$model = new Divisiones('search');
		$model->unsetAttributes();
		
		$divisiones = Divisiones::model()->findAll(array('condition'=>'estado = 1'));
		
		if (isset($_GET['Divisiones']))
			$model->setAttributes($_GET['Divisiones']);

		$this->render('admin', array(
				'divisiones' => $divisiones,
				'model' => $model,
		));
	}
	
	protected function gridDataBreakText($data,$raw) {
	
		$string =  $data->nombre;
	
		$phrase_array = explode(' ',$data->nombre);
	
		if(count($phrase_array) < 30 ){
			if(strlen($string) > 40) {
	
				$string = substr($string, 0, 35);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}
	
	protected function gridDataBreakText2($data,$raw) {
	
		$string =  $data->descripcion;
	
		$phrase_array = explode(' ',$data->descripcion);
	
		if(count($phrase_array) < 30 ){
			if(strlen($string) > 90) {
	
				$string = substr($string, 0, 85);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}

}
