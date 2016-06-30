<?php

class PresupuestoCentrosCostosController extends GxController {
    public function filters() {
    return array(
            'accessControl', 
            );
    }
    
    public function accessRules() {                  
          return array(
            array('allow',
                'actions'=>array('index','view'),                
                'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
            ),            
            array('allow',
                'actions'=>array('update'),
                'roles'=>array('admin'),               
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    } 

	public function actionView($id) {
		$model = $this->loadModel($id, 'CentrosCostos');       
        $this->layout = '//layouts/iframe';
        $this->render('view', array(
                'model' => $model,
        ));
	}

	/*public function actionCreate() {
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
	}*/

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'CentrosCostos');
		if (isset($_POST['Productos'])) {
		    $idPlanificacion = Planificaciones::model()->findAll(array('condition'=>'pp.id='.Yii::app()->session['idPeriodo'], 'join'=>'join periodos_procesos pp on t.periodo_proceso_id=pp.id')); 
		    $idPlanificacion=$idPlanificacion[0]->id;
		    $Productos = $_POST['Productos'];
             ProductosItemes::model()->deleteAll("centro_costo_id =".$id." AND planificacion_id=".$idPlanificacion);
             foreach($Productos as $rowId=>$fielId){
               $model_PI=new ProductosItemes;
               $model_PI->centro_costo_id=$id;    
               $model_PI->item_presupuestario_id=$rowId;
               $model_PI->monto=(isset($fielId['productosItemes']))?$fielId['productosItemes']:null;
               $model_PI->planificacion_id=$idPlanificacion;
               $model_PI->save(); 
            }   
             EjecucionPresupuestariaController::calcularMontoAsignadoPorCentroDeCosto();
             
             if (isset($_POST['DistribucionPresupuesto'])) {
                 $DistribucionPresupuesto = $_POST['DistribucionPresupuesto'];
                 $idProductoEstrategico=ProductosEstrategicos::model()->findAll(array(
                 'join'=>
                    'INNER JOIN objetivos_productos op ON t.id = op.producto_estrategico_id
                    INNER JOIN objetivos_estrategicos oe ON op.objetivo_estrategico_id = oe.id
                    INNER JOIN desafios_objetivos do2 ON  oe.id = do2.objetivo_estrategico_id
                    INNER JOIN desafios_estrategicos de ON do2.desafio_estrategico_id = de.id
                    INNER JOIN planificaciones pl ON de.planificacion_id = pl.id 
                    INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id',
                 'condition'=>'t.estado = 1 AND pp.id = '.Yii::app()->session['idPeriodo']                    
                    ));
                 //Eliminando productos estrategicos segun periodo   
                 foreach($idProductoEstrategico as $k=>$v){
                     ProductoEstrategicoCentroCosto::model()->deleteAll("centro_costo_id =".$id." AND producto_estrategico_id=".$v->id);
                 }
                 
                 foreach($DistribucionPresupuesto as $rowId=>$fielId){
                   $model_PECC=new ProductoEstrategicoCentroCosto;
                   $model_PECC->centro_costo_id=$id;    
                   $model_PECC->producto_estrategico_id=$rowId;
                   $model_PECC->porcentaje=$fielId['porcentaje'];
                   $model_PECC->save(); 
                 }
                      
             }          
          echo CHtml::script("parent.cerrarModal();");  
          Yii::app()->end();
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
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new Indicadores('busquedaParaPresupuestos');        
        $model->unsetAttributes();
        $this->render('index', array(
            'model' => $model,
        ));
	}

	/*public function actionAdmin() {
		$model = new CentrosCostos('search');
		$model->unsetAttributes();

		if (isset($_GET['CentrosCostos']))
			$model->setAttributes($_GET['CentrosCostos']);

		$this->render('index', array(
			'model' => $model,
		));
	}*/

}