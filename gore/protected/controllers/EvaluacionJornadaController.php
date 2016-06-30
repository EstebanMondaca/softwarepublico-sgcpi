<?php

class EvaluacionJornadaController extends GxController {

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
                //'roles'=>array('admin'),
                'expression'=>'Yii::app()->user->checkAccess("admin") && Yii::app()->user->checkAccessByCierre("EvaluacionJornadaController")',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
	/*public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'EvaluacionJornada'),
		));
	}

	public function actionCreate() {
		$model = new EvaluacionJornada;


		if (isset($_POST['EvaluacionJornada'])) {
			$model->setAttributes($_POST['EvaluacionJornada']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}*/

	public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'EvaluacionJornada'),
        ));
    }
	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'EvaluacionJornada');
		if (isset($_POST['EvaluacionJornada'])) {
			$model->setAttributes($_POST['EvaluacionJornada']);
            $destino =  Yii::getPathOfAlias('webroot').'/upload/evaluacionJornada/';
            $origenUrl= Yii::app()->request->baseUrl.'/upload/evaluacionJornada/';
            $idPeriodo=Planificaciones::model()->findAll(array('select'=>'t.id','join'=>'INNER JOIN periodos_procesos pp on pp.id=t.periodo_proceso_id','condition'=>'t.estado=1 AND pp.id='.Yii::app()->session['idPeriodo']));
            //$docAsociado = (isset($_FILES["docAsociado"]))?$_FILES["docAsociado"]:null;    
            $model->save();
            if(isset($_FILES["docAsociado"])){
                foreach($_FILES["docAsociado"]['error'] as $rowId=>$fielId){
                    if($_FILES["docAsociado"]["name"][$rowId]!=""){ 
                            $modelDoc=new EvaluacionJornadaDocumentos;                            
                            $modelDoc->fecha_creacion=new CDbExpression('NOW()');                            
                            $modelDoc->evaluacion_jornada_id=$model->id;                             
                            if($_FILES["docAsociado"]['name'][$rowId]){                               
                                $today=mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));                        
                                $arhivoFileName = $today.$rowId.$_FILES["docAsociado"]['name'][$rowId];                        
                                $modelDoc->archivo=$arhivoFileName;
                                if ($modelDoc->validate()) {
                                    if(move_uploaded_file($_FILES["docAsociado"]['tmp_name'][$rowId],$destino.''.$arhivoFileName)){
                                            if($modelDoc->save()){
                                                //Si necesitamos guardar sólo un registro debemos descomentar las siguientes 2 lineas
                                                //echo CHtml::script("parent.cerrarModal();");
                                                //Yii::app()->end();
                                            }
                                    }// end if move_uploaded_file
                                }else{
                                    print_r($modelDoc->getErrors());
                                    Yii::app()->end();
                                } 
                            }    
                    }            
                }
            }//end isset($_FILES["docAsociado"]            

            if(isset($_POST['docAsociadoEliminado'])){
                foreach($_POST['docAsociadoEliminado'] as $k=>$v){
                    $this->loadModel($v, 'EvaluacionJornadaDocumentos')->delete();
                }
            }

		}

		$this->render('update', array(
				'model' => $model,
				));
	}

    public function actionIndex(){
        if(isset(Yii::app()->session['idPeriodo'])){
            $dato=EvaluacionJornada::model()->findAll(array('condition'=>'t.estado=1 AND pl.periodo_proceso_id='.Yii::app()->session['idPeriodo'],'join'=>'INNER JOIN planificaciones pl ON t.planificacion_id = pl.id'));
            if(isset($dato[0])){
                if(Yii::app()->user->checkAccess("admin") && Yii::app()->user->checkAccessByCierre("EvaluacionJornadaController")){
                    $this->redirect(array('update', 'id' => $dato[0]->id));
                }else{
                    $this->redirect(array('view', 'id' => $dato[0]->id));
                }
            }
        }
        $this->redirect(array('/'));
    }

	/*public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'EvaluacionJornada')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('EvaluacionJornada');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new EvaluacionJornada('search');
		$model->unsetAttributes();

		if (isset($_GET['EvaluacionJornada']))
			$model->setAttributes($_GET['EvaluacionJornada']);

		$this->render('admin', array(
			'model' => $model,
		));
	}*/

}