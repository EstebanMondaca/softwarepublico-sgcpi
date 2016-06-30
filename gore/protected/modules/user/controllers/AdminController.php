<?php

class AdminController extends Controller
{
        public $defaultAction = 'admin';
        public $layout='//layouts/column2';
       
        private $_model;

        /**
         * @return array action filters
         */
        public function filters()
        {
                return CMap::mergeArray(parent::filters(),array(
                        'accessControl', // perform access control for CRUD operations
                ));
        }
        /**
         * Specifies the access control rules.
         * This method is used by the 'accessControl' filter.
         * @return array access control rules
         */
        public function accessRules()
        {
                return array(
                    array('allow',
                        'actions'=>array('view'),                
                        'roles'=>array('gestor','finanzas','supervisor','supervisor2'),
                    ),
                    array('allow', // allow admin user to perform 'admin' and 'delete' actions
                            'actions'=>array('admin','delete','create','update'),
                            //'users'=>UserModule::getAdmins(),
                            'roles'=>array('admin'),
                    ),
                    array('deny',  // deny all users
                            'users'=>array('*'),
                    ),
                );
        }
   
        /**
         * Manages all models.
         */
        public function actionAdmin()
        {
                $model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('index',array(
            'model'=>$model,
        ));
                /*$dataProvider=new CActiveDataProvider('User', array(
                        'pagination'=>array(
                                'pageSize'=>Yii::app()->controller->module->user_page_size,
                        ),
                ));

                $this->render('index',array(
                        'dataProvider'=>$dataProvider,
                ));//*/
        }


        /**
         * Displays a particular model.
         */
        public function actionView()
        {
                $model = $this->loadModel();
                $this->layout = '//layouts/iframe';
                $this->render('view',array(
                        'model'=>$model,
                ));
        }

        /**
         * Creates a new model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         */
        public function actionCreate()
        {
                $model=new User;
               // $profile=new Profile;
                
                //RCP $this->performAjaxValidation(array($model,$profile));
                $this->performAjaxValidation(array($model));
                if(isset($_POST['User']))
                {
                        $model->attributes=$_POST['User'];
                        $model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
                       // $profile->attributes=$_POST['Profile'];
                       // $profile->user_id=0;
                        if($model->validate()/*&&$profile->validate()*/) {
                                $model->password=Yii::app()->controller->module->encrypting($model->password);                                
                                
                                //try {
                                
                                    if($model->save()) {                                                                        
                                        //.. add checked materia to the alumno
                                        if(isset($_POST['User']['authItems'])){
                                            if(in_array("admin", $_POST['User']['authItems'])){
                                                $model->superuser=1;
                                                $model->save();
                                            }else{
                                                $model->superuser=0;
                                                $model->save();
                                            }
                                            foreach($_POST['User']['authItems'] as $k){                                                
                                                $userperfiles= new AuthAssignment;
                                                $userperfiles->itemname= $k;
                                                $userperfiles->userid= $model->id;
                                                $userperfiles->save(false);
                                            }         
                                        }
                                        
                                        if(isset($_POST['User']['centrosCostoses'])){
                                            foreach($_POST['User']['centrosCostoses'] as $k){
                                                $usercentros= new UsersCentros;
                                                $usercentros->centro_id= $k;
                                                $usercentros->user_id= $model->id;
                                                $usercentros->save(false);
                                            }         
                                        }  
                                    }
                                /*}
                                catch (Exception $e) {
                                        echo $e;
                                        //echo $e->getCode();                                        
                                        Yii::app()->end();
                                }*/

                                echo CHtml::script("parent.cerrarModal();");
                                Yii::app()->end();
                        }// else $profile->validate();
                }
                $this->layout = '//layouts/iframe';
                $this->render('create',array(
                        'model'=>$model,
                       // 'profile'=>$profile,
                ));
        }

        /**
         * Updates a particular model.
         * If update is successful, the browser will be redirected to the 'view' page.
         */
        public function actionUpdate()
        {
                
                $model=$this->loadModel();
                //$profile=$model->profile;
                //RCP $this->performAjaxValidation(array($model,$profile));
                $this->performAjaxValidation(array($model));
                if(isset($_POST['User']))
                {
                        $model->attributes=$_POST['User'];
                      //  $profile->attributes=$_POST['Profile'];
                        
                        if($model->validate()/*&&$profile->validate()*/) {
                                $old_password = User::model()->notsafe()->findByPk($model->id);
                                if ($old_password->password!=$model->password) {
                                        $model->password=Yii::app()->controller->module->encrypting($model->password);
                                        $model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
                                }
                               
                                if($model->save()){
                                    //..elimiando los UsersCargos
                                    AuthAssignment::model()->deleteAll('userid=:userid',array(':userid'=>$model->id));
                                    //.. add checked materia to the alumno
                                    if(isset($_POST['User']['authItems'])){
                                        if(in_array("admin", $_POST['User']['authItems'])){
                                            $model->superuser=1;
                                            $model->save();
                                        }else{
                                            $model->superuser=0;
                                            $model->save();
                                        }
                                        foreach($_POST['User']['authItems'] as $k){
                                            $userperfiles= new AuthAssignment;
                                            $userperfiles->itemname= $k;
                                            $userperfiles->userid= $model->id;
                                            $userperfiles->save(false);
                                        }         
                                    }    
                                    
                                    UsersCentros::model()->deleteAll('user_id=:user_id',array(':user_id'=>$model->id));
                                    //.. add checked materia to the alumno
                                    if(isset($_POST['User']['centrosCostoses'])){
                                        foreach($_POST['User']['centrosCostoses'] as $k){
                                            $usercentros= new UsersCentros;
                                            $usercentros->centro_id= $k;
                                            $usercentros->user_id= $model->id;
                                            $usercentros->save(false);
                                        }         
                                    }                           
                                }
                                //$profile->save();
                                echo CHtml::script("parent.cerrarModal();");
                                Yii::app()->end();
                        } //else $profile->validate();
                }
                $this->layout = '//layouts/iframe';
                $this->render('update',array(
                        'model'=>$model,
                        //'profile'=>$profile,
                ));
        }


        /**
         * Deletes a particular model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         */
        public function actionDelete()
        {
                if(Yii::app()->request->isPostRequest)
                {
                        // we only allow deletion via POST request                        
                        $model = $this->loadModel();
                        //AuthAssignment::model()->deleteAll('userid=:user_id',array(':userid'=>$model->id));
                        //UsersCentros::model()->deleteAll('user_id=:user_id',array(':user_id'=>$model->id));
                        //$profile = Profile::model()->findByPk($model->id);
						//$profile->delete();
                       	//$model->delete();
                       	
                       	//CREANDO FUNCION PARA VALIDAR SI EXISTEN DEPENDENCIAS PARA PODER ELIMINAR USUARIOS
                       	$actualizarEstado=true;
                        $tabla = $this->loadModel();//self::model(get_class($this));
                        $campoYtabla="<strong>Existen dependencias que deben ser resueltas antes de eliminar el registro.</strong>";
                        $campoYtabla.="<ul>";
                        foreach($tabla->relations() as $k=>$v)
                        {            
                            //Validando el tipo de relación
                            if($v[0]=='CHasManyRelation'){
                                //print_r($tabla->indicadores);
                                foreach($tabla->$k as $relRecord) {
                                        if($relRecord->estado=='1'){
                                            $actualizarEstado=false;    
                                            $campoYtabla.="<li>Existe una dependencia asociada al registro: '".$relRecord."'</li>";
                                        }              
                                } 
                            }                      
                       }
                        $campoYtabla.="</ul>";
                       if(!$actualizarEstado){
                            echo "<div class='alert alert-block'><button type='button' class='close' data-dismiss='alert'>×</button> <h3>Atención!</h3>".$campoYtabla."</div>";
                        }else{
                            $tabla->estado=0;
                            $tabla->save();
                       }
                        return true;
                       	//FIN CREANDO FUNCTION PARA VALIDAR...
                       	
                        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                        if(!isset($_POST['ajax']))
                                $this->redirect(array('/user/admin'));
                }
                else
                        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
       
        /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }
       
       
        /**
         * Returns the data model based on the primary key given in the GET variable.
         * If the data model is not found, an HTTP exception will be raised.
         */
        public function loadModel()
        {
                if($this->_model===null)
                {
                        if(isset($_GET['id']))
                                $this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
                        if($this->_model===null)
                                throw new CHttpException(404,'The requested page does not exist.');
                }
                return $this->_model;
        }
       
}
