<?php

class CentrosCostosController extends GxController {
    
    public function filters() {
        return array(
                'accessControl', 
                );
        }
    public function accessRules() {
          return array(
            array('allow',
                'actions'=>array('centroCostoPorUsuario','usuariosPorCentroCosto','centroCostoPorIdUsuario'),
                'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
            ),
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
		$model = new CentrosCostos('search');
		$model->unsetAttributes();

		if (isset($_GET['CentrosCostos']))
			$model->setAttributes($_GET['CentrosCostos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new CentrosCostos;


		if (isset($_POST['CentrosCostos'])) {
			$model->setAttributes($_POST['CentrosCostos']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					Yii::app()->end();
				}
				else {
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
		$model = $this->loadModel($id, 'CentrosCostos');


		if (isset($_POST['CentrosCostos'])) {
			$model->setAttributes($_POST['CentrosCostos']);

			if ($model->save()) {
				//wmulchy $this->redirect(array('view', 'id' => $model->id));
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
			$this->loadModel($id, 'CentrosCostos')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new CentrosCostos('search');
		$model->unsetAttributes();

		if (isset($_GET['CentrosCostos']))
			$model->setAttributes($_GET['CentrosCostos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new CentrosCostos('search');
		$model->unsetAttributes();

		if (isset($_GET['CentrosCostos']))
			$model->setAttributes($_GET['CentrosCostos']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	protected function gridDataBreakText($data,$raw) {
	
		$string =  $data->nombre;
	
		$phrase_array = explode(' ',$data->nombre);
	
		if(count($phrase_array) < 30 ){
			if(strlen($string) > 25) {
	
				$string = substr($string, 0, 20);
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
			if(strlen($string) > 80) {
	
				$string = substr($string, 0, 75);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}
    
    public function actionCentroCostoPorUsuario(){
        $usuario=0;
        if(isset($_POST['ElementosGestionResponsable'])){
            if(isset($_POST['ElementosGestionResponsable']['responsable_id']))
                    $usuario=$_POST['ElementosGestionResponsable']['responsable_id'];
        }
        $data=CentrosCostos::model()->with('users')->findAll(array('condition'=>'t.estado=1 AND user.id="'.$usuario.'"'));
     
        $data=CHtml::listData($data,'id','nombre');
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
        }
    }
    
    public function actionUsuariosPorCentroCosto(){
        $centroCosto=0;
        if(isset($_POST['LineasAccion'])){
            if(isset($_POST['LineasAccion']['centro_costo_id']))
                    $centroCosto=$_POST['LineasAccion']['centro_costo_id'];
        }
        $data=User::model()->with('centrosCostoses','authItems')->findAll(array('order'=>'user.ape_paterno ASC','condition'=>'centrosCostoses.id='.$centroCosto.' AND centrosCostoses.estado=1 AND user.status=1 AND user.estado=1 AND authItems.name="gestor"'));
        
        $data=CHtml::listData($data,'id','nombrecompleto');
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
        }
    }
    
    public function actionCentroCostoPorIdUsuario(){
        
    	$id_usuario=Yii::app()->user->id; 
		
		$data = UsersCentros::model()->findAll(array('condition'=>'user_id = '.$id_usuario.' ') );
		header("Content-type: application/json");
		echo CJSON::encode($data);
		
     

    }
}   