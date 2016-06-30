<?php

class PerspectivasEstrategicasController extends GxController {
        
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
		$model = new PerspectivasEstrategicas('search');
		$model->unsetAttributes();

		if (isset($_GET['PerspectivasEstrategicas']))
			$model->setAttributes($_GET['PerspectivasEstrategicas']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new PerspectivasEstrategicas;


		if (isset($_POST['PerspectivasEstrategicas'])) {
			$model->setAttributes($_POST['PerspectivasEstrategicas']);

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
		$model = $this->loadModel($id, 'PerspectivasEstrategicas');


		if (isset($_POST['PerspectivasEstrategicas'])) {
			$model->setAttributes($_POST['PerspectivasEstrategicas']);

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
			$this->loadModel($id, 'PerspectivasEstrategicas')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new PerspectivasEstrategicas('search');
		$model->unsetAttributes();

		if (isset($_GET['PerspectivasEstrategicas']))
			$model->setAttributes($_GET['PerspectivasEstrategicas']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new PerspectivasEstrategicas('search');
		$model->unsetAttributes();

		if (isset($_GET['PerspectivasEstrategicas']))
			$model->setAttributes($_GET['PerspectivasEstrategicas']);

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