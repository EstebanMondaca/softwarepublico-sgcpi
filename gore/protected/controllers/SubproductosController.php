<?php

class SubproductosController extends GxController {

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
                'actions'=>array('index','view','ver'),                
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
    
    public function actionVer($id) {
        $this->layout = '//layouts/iframe';
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Subproductos'),
        ));
    }
    
	public function actionView($id) {
		$model = new Subproductos('search');
        //$model->unsetAttributes();
        $model->producto_estrategico_id=$id;        
        $this->render('index', array(
            'model' => $model,
        ));
	}

	public function actionCreate() {
		$model = new Subproductos;
        //$modelProductosEspecificos= new ProductosEspecificos;
		if (isset($_POST['Subproductos'])) {
			$model->setAttributes($_POST['Subproductos']);
			if ($model->save()) {
				echo CHtml::script("parent.cerrarModal();");
                Yii::app()->end();
			}
		}
        $this->layout = '//layouts/iframe';
		$this->render('create', array( 'model' => $model,'modelProductosEspecificos'=>''));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Subproductos');
        $modelProductosEspecificos= new ProductosEspecificos;
        $modelProductosEspecificos->unsetAttributes();
        $modelProductosEspecificos->subproducto_id=$id;
		if (isset($_POST['Subproductos'])) {
			$model->setAttributes($_POST['Subproductos']);

			if ($model->save()) {
				//$this->redirect(array('index', 'id' => $model->id));
				echo CHtml::script("parent.cerrarModal();");
                Yii::app()->end();
			}
		}
        $this->layout = '//layouts/iframe';
		$this->render('update', array(
				'model' => $model,
				'modelProductosEspecificos'=>$modelProductosEspecificos
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Subproductos')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex($id_producto_estrategico){
		$model = new Subproductos('search');
        $model->unsetAttributes();
        $model->producto_estrategico_id=$id_producto_estrategico;
        $this->render('index', array(
            'model' => $model,
        ));
	}
}