<?php

class SubcriteriosController extends GxController {
	
	
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
		$model = new Subcriterios('search');
		$model->unsetAttributes();

		if (isset($_GET['Subcriterios']))
			$model->setAttributes($_GET['Subcriterios']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new Subcriterios;


		if (isset($_POST['Subcriterios'])) {
			$model->setAttributes($_POST['Subcriterios']);

			if ($model->save()) {
				echo CHtml::script("parent.cerrarModal();");
				Yii::app()->end();
			}
		}
		
		$this->layout = '//layouts/iframe';
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Subcriterios');


		if (isset($_POST['Subcriterios'])) {
			$model->setAttributes($_POST['Subcriterios']);

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
			$this->loadModel($id, 'Subcriterios')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new Subcriterios('search');
		$model->unsetAttributes();
		
		$criterios = Criterios::model()->findAll(array('condition'=>'estado = 1'));
		
		if (isset($_GET['Subcriterios']))
			$model->setAttributes($_GET['Subcriterios']);

		$this->render('admin', array(
			'model' => $model,
			'criterios' => $criterios,
		));
	}

	public function actionAdmin() {
			
		$model = new Subcriterios('search');
		$model->unsetAttributes();

		if (isset($_GET['Subcriterios']))
			$model->setAttributes($_GET['Subcriterios']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	protected function gridDataBreakText($data,$raw) {
	
		$string =  $data->nombre;
	
		$phrase_array = explode(' ',$data->nombre);
	
		if(count($phrase_array) < 10 ){
			if(strlen($string) > 80) {
	
				$string = substr($string, 0, 75);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}

}