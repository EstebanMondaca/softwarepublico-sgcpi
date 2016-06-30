<?php

class PreferenciasController extends GxController
{
	/**
	 * Declares class-based actions.
	 */
	public function filters() {
    return array(
            'accessControl', 
            );
    }
    
	public function accessRules() {
        return array(
                array('allow',
                    'actions'=>array('index'),
                    'roles'=>array('admin'),
                    ),                
                array('deny',  // deny all other users
                        'users'=>array('*'),
                        ),
                );
    }
	
	

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{		
		$this->render('index');
	}	
}