<?php

class SiteController extends GxController
{
	/**
	 * Declares class-based actions.
	 */
	

	public function accessRules() {
        return array(
                array('allow',
                    'actions'=>array('index', 'view', 'login'),
                    'users'=>array('*'),
                    ),
                array('allow',
                    'actions'=>array('profile', 'logout', /*'changepassword', 'passwordexpired', 'delete'*/ 'browse'),
                    'users'=>array('@'),
                    ),
                /*array('allow',
                    'actions'=>array('admin','delete','create','update', 'list', 'assign', 'generateData', 'csv'),
                    'expression' => 'Yii::app()->user->isAdmin()'
                    ),
                array('allow',
                    'actions'=>array('create'),
                    'expression' => 'Yii::app()->user->can("user_create")'
                    ),
                array('allow',
                    'actions'=>array('admin'),
                    'expression' => 'Yii::app()->user->can("user_admin")'
                    ),*/
                array('deny',  // deny all other users
                        'users'=>array('*'),
                        ),
                );
    }
	
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	
	/**
	 * This is the default 'reportes' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionReportes()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('reportes');
	}
	
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionMenuJson($id)
	{
		
		//Consultamos por el anio del proceso asociado al ID
		$wherePeriodoProcesos = PeriodosProcesos::model()->find("id =".$id);
		
		$activacionProceso =  (GxHtml::encodeEx(GxHtml::listDataEx(ActivacionProceso::model()->findAllAttributes(null, true))));
		
		unset(Yii::app()->session['idPeriodoSelecionado']); //Para eliminar una varibale de sesion
	
		//Asignamos a la variable de sesion la descripcion del identificador
		Yii::app()->session['idPeriodoSelecionado'] = $wherePeriodoProcesos['descripcion'];
		
		$this->renderPartial('menuJson',array('id'=>$id));
		
	}
}