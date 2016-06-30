<?php

class ElementosGestionController extends GxController {

    public function filters() {
    return array(
            'accessControl', 
            );
    }
    
    public function accessRules() {
          return array(
            array('allow',
                'actions'=>array('index','view','indexLA','obtenerSubCriterios2'),                
                'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
            ),
            array('allow',
                'actions'=>array('update','create','delete','admin'),
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
    
	public function actionView($id) {
		$model = new ElementosGestion('search');
		$model->unsetAttributes();

		if (isset($_GET['ElementosGestion']))
			$model->setAttributes($_GET['ElementosGestion']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
    
    public function actionIndexLA() {
        $model = new ElementosGestion('search');
        $model->unsetAttributes();
        $criterios = Criterios::model()->findAll(array('condition'=>'estado = 1'));
        if (isset($_GET['ElementosGestion']))
            $model->setAttributes($_GET['ElementosGestion']);
        $this->layout = '//layouts/iframe_for_index';
        $this->render('indexla', array(
            'model' => $model,
            'criterios'=>$criterios
        ));
    }

	public function actionCreate() {
		$model = new ElementosGestion;

		if (isset($_POST['ElementosGestion'])) {
			$model->setAttributes($_POST['ElementosGestion']);

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
		$this->render('create', array( 'model' => $model,
						));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'ElementosGestion');


		if (isset($_POST['ElementosGestion'])) {
			$model->setAttributes($_POST['ElementosGestion']);

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
			$this->loadModel($id, 'ElementosGestion')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new ElementosGestion('search');
		$model->unsetAttributes();
		
		$criterios = Criterios::model()->findAll(array('condition'=>'estado = 1'));

		if (isset($_GET['ElementosGestion']))
			$model->setAttributes($_GET['ElementosGestion']);

		$this->render('admin', array(
			'model' => $model,
			'criterios' => $criterios,
		));
	}

	public function actionAdmin() {
		$model = new ElementosGestion('search');
		$model->unsetAttributes();

		if (isset($_GET['ElementosGestion']))
			$model->setAttributes($_GET['ElementosGestion']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	protected function gridDataBreakText($data,$raw) {
	
		$string =  $data->nombre;
	
		$phrase_array = explode(' ',$data->nombre);
	
		if(count($phrase_array) < 5 ){
			if(strlen($string) > 100) {
	
				$string = substr($string, 0, 95);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}
	
	public function actionObtenerSubCriterios2($id){
	
		$subCriterios = Subcriterios::model()->findAll(array('condition'=>'id_criterio = '.$id.' AND estado = 1') );
	
		header("Content-type: application/json");
		echo CJSON::encode($subCriterios);
	}

}