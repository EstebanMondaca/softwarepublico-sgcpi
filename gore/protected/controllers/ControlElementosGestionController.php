<?php

class ControlElementosGestionController extends GxController {

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
                'actions'=>array('update','borrarDocumento'),
                'expression'=>''.Yii::app()->user->checkAccessChangeFromElementosDeGestionSegunCC(array('modelName'=>'ElementosGestion','from'=>'controlElementosGestion','idRow'=>(isset($_GET['id']))?$_GET['id']:null)),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
    
	public function actionView($id) {
		$model = $this->loadModel($id, 'ElementosGestion');
        $this->layout = '//layouts/iframe';
		$this->render('view', array(
			'model' => $model,
		));
	}
    


	public function actionUpdate($id) {
	    ini_set('upload_max_filesize', '10M');	    
		$model = $this->loadModel($id, 'ElementosGestion');
        
        //$model=new CActiveDataProvider('ElementosGestion', array('criteria'=>$Criteria));
        //$model=ElementosGestion::model()->findAll($Criteria);
		//$model=ElementosGestion::model()->with('laElemGestions')->findAll(array('condition'=>'t.id='.$id.' AND laElemGestions.id_planificacion ='.Yii::app()->session['idPlanificaciones']));
		//print_r($model->laElemGestions);
        //Yii::app()->end();
        
		if (isset($_POST['laElemGestions'])){//Yii::app()->session['idPlanificaciones
		    //Almacenando LA de elementos de gestión
            $LaElemGestion = $_POST['laElemGestions'];
            if(count($LaElemGestion)>0)
            {
                $destino =  Yii::getPathOfAlias('webroot').'/upload/controlElementosGestion/';
                $origenUrl= Yii::app()->request->baseUrl.'/upload/controlElementosGestion/';
                
                $idPeriodo=Planificaciones::model()->findAll(array('select'=>'t.id','join'=>'INNER JOIN periodos_procesos pp on pp.id=t.periodo_proceso_id','condition'=>'t.estado=1 AND pp.id='.Yii::app()->session['idPeriodo']));
                foreach($LaElemGestion as $rowId=>$fielId)
                {                    
                	$rowForUpload=$rowId;
                    //Es de tipo entero, por lo tanto es actualización porque viene el ID
                    if(is_numeric($rowId)){
                        $model_la=$this->loadModel($rowId, 'LaElemGestion');
                        $model_la->evidencia = $fielId['evidencia'];
                        $model_la->puntaje_real=$fielId['puntaje_real'];
                        $model_la->archivo= "";
                    	$model_la->save();
                    }else{
                        $model_la=new LaElemGestion;
                        $model_la->id_la=(isset($_POST['id_la']))?$_POST['id_la']:null;
                        $model_la->id_elem_gestion=$_POST['id_elem_gestion'];//$fielId['id_elem_gestion'];
                        $model_la->id_planificacion=$idPeriodo[0]->id;  
                        $model_la->evidencia=$fielId['evidencia'];
                        $model_la->puntaje_esperado=$_POST['puntaje_esperado'];
                        $model_la->fecha=date('Y-m-d',strtotime($fielId['fecha']));
                        $model_la->puntaje_real = $fielId['puntaje_real'];
                        $model_la->archivo= "";
                        $model_la->save();
                        $rowForUpload=$model_la->id;
                        
                    }
                    
                    if(isset($_FILES['laElemGestions']['name'][$rowId]['archivo'])){
                    	$today = date("YmdHis");
                        foreach($_FILES['laElemGestions']['name'][$rowId]['archivo'] as $key => $filename)
                        {
                        	$arhivoFileName = $today.$filename;
                        	$textoLimpio = preg_replace('([^A-Za-z0-9._])', '', $arhivoFileName);
                        	 if(move_uploaded_file($_FILES['laElemGestions']['tmp_name'][$rowId]['archivo'][$key],$destino.''.$textoLimpio))
                        	 {
	                        	$modelDocumentos = new LaElemGestionDocumentos;
	                            $modelDocumentos->nombre=$textoLimpio;
	                            $modelDocumentos->la_elem_id= $rowForUpload;
	                            $modelDocumentos->save(false); 
                        	 }
                        }
                        
                    	/*if($model_la->save()){
                                        //Si necesitamos guardar más de un registro debemos sacar las siguientes 2 lineas
                                        echo CHtml::script("parent.cerrarModal();");
                                        Yii::app()->end();
                         }*/
                                    
                        
                        /*test MCP
                        $arhivoFileName = $today.$_FILES['laElemGestions']['name'][$rowId]['archivo'];                        

                        $model_la->archivo=$arhivoFileName;
                        if ($model_la->validate()) {
                            if(move_uploaded_file($_FILES['laElemGestions']['tmp_name'][$rowId]['archivo'],$destino.''.$arhivoFileName)){

                            		if($model_la->save()){
                                        //Si necesitamos guardar más de un registro debemos sacar las siguientes 2 lineas
                                        echo CHtml::script("parent.cerrarModal();");
                                        Yii::app()->end();
                                    }      
                            }// end if move_uploaded_file
                        }else{
                            print_r($model_la->getErrors());
                            Yii::app()->end();
                        }
                        */  
                        
                        echo CHtml::script("parent.cerrarModal();");
                         Yii::app()->end();
                        
                    }else{
                       if($model_la->save()){
                           echo CHtml::script("parent.cerrarModal();");
                           Yii::app()->end();
                       }else{
                           print_r($model_la->getErrors());
                           Yii::app()->end();
                       }
                    }
                    
                      
                } //End foreach-->
            }
            
			//$model->setAttributes($_POST['ElementosGestion']);            
			/*if ($model->save()) {
				//$this->redirect(array('view', 'id' => $model->id));
				echo CHtml::script("parent.cerrarModal();");
				Yii::app()->end();
			}*/
		}//end if (isset($_POST['laElemGestions'])		
        $this->layout = '//layouts/iframe';
		$this->render('update', array(
				'model' => $model,
		));
	}

	/*public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'ElementosGestion')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}*/

	public function actionIndex() {
		$model = new ElementosGestion('searchControl');
		$model->unsetAttributes();
		
		//$criteria = new CDbCriteria;        
        //$criteria->compare('estado', 1);
		
        //$model=new CActiveDataProvider('ElementosGestion', array('criteria' => $criteria));
        
        
		$criterios = Criterios::model()->findAll(array('condition'=>'estado = 1'));
        
        //$model->setAttributes(array('id_subcriterio'=>'121434'));//NULL; 
		if (isset($_GET['ElementosGestion'])){
		    $model->setAttributes($_GET['ElementosGestion']);
		}       //CDbExpression('NULL'); 
        
        
		$this->render('index', array(
			'model' => $model,
			'criterios' => $criterios,
		));
	}
	public function actionBorrarDocumento($id){
		//$valor = $_GET["valor"];
		//$id = $_GET["id"];
		$resultado = false;
		$modelCierre = $this->loadModel($id, 'LaElemGestionDocumentos');
		
		$modelCierre->estado = "0";
		if ($modelCierre->update()){
			$resultado = true;
		}
			
		header("Content-type: application/json");	
		echo CJSON::encode($resultado);
	}
	
		
	/*public function actionAdmin() {
		$model = new ElementosGestion('search');
		$model->unsetAttributes();

		if (isset($_GET['ElementosGestion']))
			$model->setAttributes($_GET['ElementosGestion']);

		$this->render('index', array(
			'model' => $model,
		));
	}*/

}