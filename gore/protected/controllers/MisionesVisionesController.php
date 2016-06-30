<?php

class MisionesVisionesController extends Controller
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
            'accessControl', // perform access control for CRUD operations
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{		
		$criteria = new CDbCriteria;
        if(isset(Yii::app()->session['idPeriodo'])){
            $criteria->join='INNER JOIN planificaciones p ON p.id=t.planificacion_id  inner join periodos_procesos pp on pp.id=p.periodo_proceso_id';
           $criteria->condition='pp.id = '.Yii::app()->session['idPeriodo'];
        }else{
            $criteria->condition='t.id=0';
        } 
        $dataProvider=new CActiveDataProvider('MisionesVisiones', array(
            'criteria' => $criteria,
        ));
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		//$model=new MisionesVisiones;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		/*if(isset($_POST['MisionesVisiones']))
		{
			$model->attributes=$_POST['MisionesVisiones'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('index',array(
			'model'=>$model,
		));*/
		$criteria = new CDbCriteria;
        if(isset(Yii::app()->session['idPeriodo'])){
            $criteria->join='INNER JOIN planificaciones p ON p.id=t.planificacion_id  inner join periodos_procesos pp on pp.id=p.periodo_proceso_id';
            $criteria->condition='pp.id = '.Yii::app()->session['idPeriodo'];
        }else{
            $criteria->condition='t.id=0';
        } 
        $dataProvider=new CActiveDataProvider('MisionesVisiones', array(
            'criteria' => $criteria,
        ));
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MisionesVisiones']))
		{
			$model->attributes=$_POST['MisionesVisiones'];
			if($model->save()){
			    //if (!empty($_GET['asDialog']))
                //{
                    echo CHtml::script("parent.cerrarModal();");
                    Yii::app()->end();
               //}else
               //    $this->redirect(array('index','id'=>$model->id));
			}				
		}
        
       // if (!empty($_GET['asDialog']))
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
		/*$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/
		$criteria = new CDbCriteria;
        if(isset(Yii::app()->session['idPeriodo'])){
            $criteria->join='INNER JOIN planificaciones p ON p.id=t.planificacion_id  inner join periodos_procesos pp on pp.id=p.periodo_proceso_id';
            $criteria->condition='pp.id = '.Yii::app()->session['idPeriodo'];
        }else{
            $criteria->condition='t.id=0';
        } 
        $dataProvider=new CActiveDataProvider('MisionesVisiones', array(
            'criteria' => $criteria,
        ));
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		$criteria = new CDbCriteria;
        if(isset(Yii::app()->session['idPeriodo'])){
            $criteria->join='INNER JOIN planificaciones p ON p.id=t.planificacion_id  inner join periodos_procesos pp on pp.id=p.periodo_proceso_id';
            $criteria->condition='pp.id = '.Yii::app()->session['idPeriodo'];
        }else{
            $criteria->condition='t.id=0';
        } 
        $dataProvider=new CActiveDataProvider('MisionesVisiones', array(
            'criteria' => $criteria,
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		/*$model=new MisionesVisiones('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MisionesVisiones']))
			$model->attributes=$_GET['MisionesVisiones'];

		$this->render('admin',array(
			'model'=>$model,
		));*/
		
        $criteria = new CDbCriteria;
        if(isset(Yii::app()->session['idPeriodo'])){
            $criteria->join='INNER JOIN planificaciones p ON p.id=t.planificacion_id  inner join periodos_procesos pp on pp.id=p.periodo_proceso_id';
            $criteria->condition='pp.id = '.Yii::app()->session['idPeriodo'];
        }else{
            $criteria->condition='t.id=0';
        } 
        $dataProvider=new CActiveDataProvider('MisionesVisiones', array(
            'criteria' => $criteria,
        ));
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=MisionesVisiones::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='misiones-visiones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
