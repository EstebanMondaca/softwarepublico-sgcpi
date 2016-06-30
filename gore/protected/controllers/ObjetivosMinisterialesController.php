<?php

class ObjetivosMinisterialesController extends GxController {
    
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
		$model = new ObjetivosMinisteriales('search');
		$model->unsetAttributes();

		if (isset($_GET['ObjetivosMinisteriales']))
			$model->setAttributes($_GET['ObjetivosMinisteriales']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new ObjetivosMinisteriales;


		if (isset($_POST['ObjetivosMinisteriales'])) {
			$model->setAttributes($_POST['ObjetivosMinisteriales']);
			//$relatedData = array(
				//'objetivosEstrategicoses' => $_POST['ObjetivosMinisteriales']['objetivosEstrategicos'] === '' ? null : $_POST['ObjetivosMinisteriales']['objetivosEstrategicoses'],
			//	);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else{
					//$this->redirect(array('view', 'id' => $model->id));
					echo CHtml::script("parent.cerrarModal();");
					Yii::app()->end();
				}
			}
// 			if ($model->saveWithRelated($relatedData)) {
// 				if (Yii::app()->getRequest()->getIsAjaxRequest())
// 					Yii::app()->end();
// 				else{
// 					$this->redirect(array('view', 'id' => $model->id));
// 					echo CHtml::script("parent.cerrarModal();");
// 					Yii::app()->end();
// 				}
// 			}
		}
		
		$this->layout = '//layouts/iframe';
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'ObjetivosMinisteriales');


		if (isset($_POST['ObjetivosMinisteriales'])) {
			$model->setAttributes($_POST['ObjetivosMinisteriales']);
			
			if ($model->save()) {
				//$this->redirect(array('view', 'id' => $model->id));
				echo CHtml::script("parent.cerrarModal();");
				Yii::app()->end();
			}

// 			$relatedData = array(
// 				'objetivosEstrategicoses' => $_POST['ObjetivosMinisteriales']['objetivosEstrategicoses'] === '' ? null : $_POST['ObjetivosMinisteriales']['objetivosEstrategicoses'],
// 				);

// 			if ($model->saveWithRelated($relatedData)) {
// 				echo CHtml::script("parent.cerrarModal();");
// 				Yii::app()->end();
// 				$this->redirect(array('view', 'id' => $model->id));
// 			}
		}
		
		$this->layout = '//layouts/iframe';
		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'ObjetivosMinisteriales')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new ObjetivosMinisteriales('search');
		$model->unsetAttributes();

		if (isset($_GET['ObjetivosMinisteriales']))
			$model->setAttributes($_GET['ObjetivosMinisteriales']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new ObjetivosMinisteriales('search');
		$model->unsetAttributes();

		if (isset($_GET['ObjetivosMinisteriales']))
			$model->setAttributes($_GET['ObjetivosMinisteriales']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	protected function gridDataBreakText($data,$raw) {
	
		$string =  $data->nombre;
	
		$phrase_array = explode(' ',$data->nombre);
	
		if(count($phrase_array) < 5 ){
			if(strlen($string) > 60) {
	
				$string = substr($string, 0, 55);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}
	
	protected function gridDataBreakText2($data,$raw) {
	
		$string =  $data->descripcion;
	
		$phrase_array = explode(' ',$data->descripcion);
	
		if(count($phrase_array) < 5 ){
			if(strlen($string) > 70) {
	
				$string = substr($string, 0, 65);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}

}