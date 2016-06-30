<?php
ini_set('max_execution_time', 3000);
class ActividadesController extends GxController {

    public function filters() {
    return array(
            'accessControl', 
            );
    }
    
    public function accessRules() {                  
          return array(
            array('allow',
                'actions'=>array('index','view','ver'),                
                'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
            ),
            array('allow',
                'actions'=>array('create'),
                //Validamos si el usuario tiene permisos para crear una actividad como responsable del indicador que está queriendo agregar
               'expression'=>''.Yii::app()->user->checkAccessChange(array('modelName'=>'Indicadores','fieldName'=>'responsable_id','idRow'=>(isset($_GET['idIndicador']))?$_GET['idIndicador']:null)),
            ),
            array('allow',
                'actions'=>array('update','delete','UpdateHitosActividades'),
                //Validamos si el usuario tiene permisos para editar como responsable del indicador o tiene un rol admin
               'expression'=>''.Yii::app()->user->checkAccessChange(array('modelName'=>'Actividades','fieldName'=>'indicador->responsable_id','idRow'=>(isset($_GET['id']))?$_GET['id']:null)),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    } 
	public function actionView($id) {
		$modelActividades = new Actividades;        
        $modelActividades->indicador_id=$id;
        $this->layout = '//layouts/iframe';
        $this->render('updateMain', array(
                'modelActividades'=>$modelActividades
        ));
	}
    
    public function actionVer($id) {
        $ListadoDeActividades=Actividades::model()->findAll(array('condition'=>'indicador_id='.$id));
        $modelActividades=array();
        foreach($ListadoDeActividades as $actividad){
            array_push($modelActividades,$model = $this->loadModel($actividad->id, 'Actividades'));            
        }
        $this->layout = '//layouts/iframe';
        $this->render('view', array(
            'modelActividades' => $modelActividades,
        ));
    }

	public function actionCreate() {
		$model = new Actividades;
        if (isset($_POST['Actividades'])) {
			$model->setAttributes($_POST['Actividades']);
			$relatedData = array(
				//'itemesPresupuestarioses' => (!isset($_POST['Actividades']['itemesPresupuestarioses']))? null : $_POST['Actividades']['itemesPresupuestarioses'],
				);

			if ($model->saveWithRelated($relatedData)) {
			    ItemesActividades::model()->deleteAll('actividad_id=:actividad_id',array(':actividad_id'=>$model->id));			    
                if(isset($_POST['Actividades']['itemesPresupuestarioses'])){                    
                    foreach($_POST['Actividades']['itemesPresupuestarioses'] as $k){
                        $itemActividad= new ItemesActividades;
                        $itemActividad->item_presupuestario_id= $k;
                        $itemActividad->actividad_id= $model->id;
                        $itemActividad->monto=$_POST['Actividades']['itemesActividades']['i'.$k];
                        $itemActividad->save(false);
                    }
                    EjecucionPresupuestariaController::calcularMontoAsignadoPorCentroDeCosto();
                }
				/*if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('index', 'id' => $model->id));*/
					
			     //almacenando hitos de actividades según un indicador.
			     $tipoFrecuencia=$model->indicador->frecuencia_control_id;
                 $arrayMensual=array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
                 if($tipoFrecuencia==2){
                     //el array debe ser trimestral
                     $arrayMensual=Array("marzo","junio","septiembre","diciembre");
                 }
                 foreach($arrayMensual as $k=>$v){
                     $modelHitosActividades=new HitosActividades;
                     $modelHitosActividades->id_actividad=$model->id;
                     $modelHitosActividades->actividad_mes=$v;
                     $modelHitosActividades->save(false);
                 }
			     
				echo CHtml::script("parent.parent.actualizarCierreModal();parent.cerrarPanelIframe();");
                Yii::app()->end();
			}
		}
        $this->layout = '//layouts/iframe';
		$this->render('create', array( 'model' => $model));
	}
	public function actionUpdateHitosActividades(){
	
		
		$modelActividades = Actividades::model()->findAll(
				array('select'=>'t.id,t.indicador_id, ff.nombre',
	         			'join'=>'INNER JOIN indicadores ind on ind.id = t.indicador_id
	         					 INNER JOIN frecuencias_controles ff on ff.id = ind.frecuencia_control_id',
	         			'condition'=>'t.estado = 1 AND ind.frecuencia_control_id IS NOT NULL',
	         	)
		);
		foreach($modelActividades AS $result){
 			$meses=array();
 			if(strtoupper($result->nombre)=='MENSUAL'){
 				$meses=array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");		
 			}else{
 				$meses=Array("marzo","junio","septiembre","diciembre");
 			}
 			
 			foreach($meses AS $mes){
 				$modelHitos = HitosActividades::model()->findAll(array('condition'=>'t.estado = 1 AND t.id_actividad="'.$result->id.'" AND actividad_mes="'.$mes.'"'));
 				if(!isset($modelHitos[0])){
                     $modelHitosActividades=new HitosActividades;
                     $modelHitosActividades->id_actividad=$result->id;
                     $modelHitosActividades->actividad_mes=$mes;
                     $modelHitosActividades->save(false);
 				}
 			}
 			
		}      
		
	
	}
	public function actionUpdate($id) {
	   // $modelActividades = new Actividades;        
       // $modelActividades->indicador_id=$id;
		$model = $this->loadModel($id, 'Actividades');
		if (isset($_POST['Actividades'])) {
			$model->setAttributes($_POST['Actividades']);
			$relatedData = array(
			//	'itemesPresupuestarioses' => $_POST['Actividades']['itemesPresupuestarioses'] === '' ? null : $_POST['Actividades']['itemesPresupuestarioses'],
				);
            //NO GUARDA LOS itemesActividades $K
			if ($model->saveWithRelated($relatedData)) {
			    ItemesActividades::model()->deleteAll('actividad_id=:actividad_id',array(':actividad_id'=>$model->id));
                if(isset($_POST['Actividades']['itemesPresupuestarioses'])){
                    foreach($_POST['Actividades']['itemesPresupuestarioses'] as $k){
                        $itemActividad= new ItemesActividades;
                        $itemActividad->item_presupuestario_id= $k;
                        $itemActividad->actividad_id= $model->id;
                        $itemActividad->monto=$_POST['Actividades']['itemesActividades']['i'.$k];
                        $itemActividad->save(false);
                    }
                    EjecucionPresupuestariaController::calcularMontoAsignadoPorCentroDeCosto();
                }
                //almacenando hitos de actividades según un indicador.
                 $tipoFrecuencia=$model->indicador->frecuencia_control_id;
                 $arrayMensual=array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
                 if($tipoFrecuencia==2){
                     //el array debe ser trimestral
                     $arrayMensual=Array("marzo","junio","septiembre","diciembre");
                 }
                 foreach($arrayMensual as $k=>$v){
                     $modelHitos = HitosActividades::model()->findAll(array('condition'=>'t.estado = 1 AND t.id_actividad="'.$model->id.'" AND t.actividad_mes="'.$v.'"'));
                     if(!isset($modelHitos[0])){
                             $modelHitosActividades=new HitosActividades;
                             $modelHitosActividades->id_actividad=$model->id;
                             $modelHitosActividades->actividad_mes=$v;
                             $modelHitosActividades->save(false);
                     }
                 }
				echo CHtml::script("parent.parent.actualizarCierreModal();parent.cerrarPanelIframe();");
                Yii::app()->end();
			}
		}
        $this->layout = '//layouts/iframe';
		$this->render('update', array(
				'model'=>$model
		));
        
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Actividades')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new Indicadores('busquedaParaActividades');
        $model->unsetAttributes();
        $this->render('index', array(
            'model' => $model,
        ));
	}
    
    
    /*protected function validateAccess(){
        $owner_id='';
           //Si viene el idIndicador es porque estamos actualizando o eliminando una actividad de un indicador
           if(Yii::app()->user->checkAccess("admin")){
               $owner_id=TRUE;
           }else{
               if(isset($_GET['idIndicador'])){
                   $model = Indicadores::model()->findAll(array('condition'=>'t.id='.$_GET['idIndicador']));
                   $userID = Yii::app()->user->id;
                   if(isset($model[0]->responsable_id)){
                       $owner_id=$model[0]->responsable_id;
                   } 
                   //Verificando si el usuario tiene permisos para acceder o si es admin     
                   $owner_id=($userID === $owner_id);               
                }
           }
           
       return $owner_id;
    }
    */
    /* public static function validateAccessbyIndicador($idIndicador=0){
       $owner_id=FALSE;     
       if(Yii::app()->user->checkAccess("admin")){
           $owner_id=TRUE;
       }else{
           $model = Indicadores::model()->findAll(array('condition'=>'t.id='.$idIndicador));
           $userID = Yii::app()->user->id;
           if(isset($model[0]->responsable_id)){
               $owner_id=$model[0]->responsable_id;
           } 
           //Verificando si el usuario tiene permisos para acceder o si es admin     
           $owner_id=(($userID === $owner_id));
       }     
       
       return $owner_id;
    }*/
    
    /*protected function normalAccess($user,$rule)
    {        
        //only allow if (authorID = userID) or (authorID <> userID and view_mode == public)
        $model = Indicadores::model()->findAll(array('condition'=>'t.id='.$_GET['idIndicador']));
        $userID = Yii::app()->user->id;
        if(isset($model[0]->responsable_id)){            
            return ($userID === $model[0]->responsable_id) ||  
            ($user !== $model[0]->responsable_id && $model->view_mode === self::MODE_PUBLIC); 
        }else{
            return false;   
        } 
                   
    }*/

}