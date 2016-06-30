<?php

class DesafiosEstrategicosController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
                'actions'=>array('update','create','delete'),
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
	

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
	    $this->layout = '//layouts/iframe';
		$this->render('view', array(
            'model' => $this->loadModel($id, 'DesafiosEstrategicos'),
        ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new DesafiosEstrategicos;

		if(isset($_POST['DesafiosEstrategicos']))
		{
			$model->attributes=$_POST['DesafiosEstrategicos'];
			if($model->save()){
                    echo CHtml::script("parent.cerrarModal();");
                    Yii::app()->end();
			}	
		}
	       //	if (!empty($_GET['asDialog']))
            $this->layout = '//layouts/iframe';
            
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{  
           
		$model=$this->loadModel($id);

		if(isset($_POST['DesafiosEstrategicos']))
		{
			$model->attributes=$_POST['DesafiosEstrategicos'];
			if($model->save()){
 					echo CHtml::script("parent.cerrarModal();");
                    Yii::app()->end();
			}
				
		}
        //if (!empty($_GET['asDialog']))
            $this->layout = '//layouts/iframe';
        
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionIndex()
	{	                    
                
         //$controller = ucfirst('DesafiosEstrategicosController');  
         //print_r($controller->getController());
         //echo (Yii::app()->user->checkAccessChangeDataGore('DesafiosEstrategicosController'))?"PUEDE EDITAR":"NO PUEDE EDITAR";
         //$validateRow=array('modelName'=>'Indicadores','fieldName'=>'responsable_id','idRow'=>8);         
         //echo (Yii::app()->user->checkAccessChangeDataGore('DesafiosEstrategicosController',$validateRow))?"PUEDE EDITAR":"NO PUEDE EDITAR";
         
         // print_r(Yii::app()->authManager->getRoles(Yii::app()->user->id));
		$model=new DesafiosEstrategicos('search');
		$model->unsetAttributes();  // clear any default values
		//$model->planificacion->periodoProceso->descripcion='2012';
		if(isset($_GET['DesafiosEstrategicos']))
			$model->attributes=$_GET['DesafiosEstrategicos'];	   
		$this->render('index',array(
			//'dataProvider'=>$dataProvider,
			'model'=>$model,
		));		
	}

	/**
	 * Manages all models.
	 */


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=DesafiosEstrategicos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    
    
    
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='desafios-estrategicos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
		
}
