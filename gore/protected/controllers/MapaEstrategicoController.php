<?php

class MapaEstrategicoController extends GxController {
    
    public function filters() {
        return array(
                'accessControl', 
                );
        }
    public function accessRules() {
          return array(
           array('allow',
                'actions'=>array('reporte','view','viewObjetivo'),
                'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
            ),
            array('allow',
                'actions'=>array('update','index'),
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
        
	public function actionUpdate($id)
    {           
        $model = $this->loadModel($id, 'DesafiosEstrategicos');
        if(isset($_POST['DesafiosEstrategicos']))
        {
            
             //Eliminando asociación de desafios según desafios estrategicos   
             DesafioDesafio::model()->deleteAll("desafio_estrategico_id =".$id);             
             $DesafiosEstrategicos = $_POST['DesafiosEstrategicos'];
             foreach($DesafiosEstrategicos['desafioDesafios'] as $rowId=>$fielId){
               $model_DE=new DesafioDesafio;
               $model_DE->desafio_estrategico_id=$id;    
               $model_DE->desafio_estrategico_mm_id=$fielId;
               $model_DE->save(); 
            }
            
            echo CHtml::script("parent.cerrarModal();");
            Yii::app()->end();    
        }
        
        $this->layout = '//layouts/iframe';
        
        $this->render('update',array(
            'model'=>$model,
        ));
    }
    
	public function actionIndex()
    {                       
        $model=new DesafiosEstrategicos('search');
        $model->unsetAttributes();        
        if(isset($_GET['DesafiosEstrategicos']))
            $model->attributes=$_GET['DesafiosEstrategicos'];      
        $this->render('index',array(
            'model'=>$model,
        ));     
    }
    
	public function actionReporte(){
       $modelDesafiosEstrategicos=DesafiosEstrategicos::model()->findAll(array('select'=>'t.*','distinct'=>true,'condition'=>'pp.id = '.Yii::app()->session['idPeriodo'].' AND t.estado = 1','join'=>'INNER JOIN planificaciones p ON t.planificacion_id=p.id  inner join periodos_procesos pp on pp.id=p.periodo_proceso_id'));
       $modelObjetivosEstrategicos=ObjetivosEstrategicos::model()->findAll(array('select'=>'t.*','distinct'=>true,'condition'=>'pp.id = '.Yii::app()->session['idPeriodo'].' AND t.estado = 1','join'=>'INNER JOIN desafios_objetivos do ON t.id = do.objetivo_estrategico_id            INNER JOIN desafios_estrategicos de ON do.desafio_estrategico_id = de.id            INNER JOIN planificaciones pl ON de.planificacion_id = pl.id            INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id'));
        
        $this->render('reporte' ,array(
                'modelDesafiosEstrategicos' => $modelDesafiosEstrategicos,
                'modelObjetivosEstrategicos'=>$modelObjetivosEstrategicos
        ));
    } 

    public function actionView($id)
    {
        $this->layout = '//layouts/iframe';
        $this->render('view', array(
            'model' => $this->loadModel($id, 'DesafiosEstrategicos'),
        ));
    }

    public function actionViewObjetivo($id) {
        $this->layout = '//layouts/iframe';
        $this->render('viewObjetivo', array(
            'model' => $this->loadModel($id, 'ObjetivosEstrategicos'),
        ));
    }

}