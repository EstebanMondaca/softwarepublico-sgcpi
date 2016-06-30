<?php

class ProductosEstrategicosController extends GxController {

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
                'actions'=>array('update','create','delete','admin','orden'),
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
    //Página de inicio de los productos estrategicos
	public function actionView($id) {                
		$model = new ProductosEstrategicos('search');
        $model->unsetAttributes();
        $modelSubproductos = TiposProductos::model()->find(array('condition'=>'id='.$id));
        $tipoProducto=$modelSubproductos->nombre;
        $this->render('index', array(
            'model' => $model,'tipoProducto'=>$tipoProducto,'tipo_producto_id'=>$id
        )); 
	}
        
    public function actionVer($id) {
        $this->layout = '//layouts/iframe';                
        $this->render('view', array(
            'model' => $this->loadModel($id, 'ProductosEstrategicos'),
        ));  
    }
    
    public function actionOrden($id) {
        
        $model = new ProductosEstrategicos('searchOrden');       
        
    	if (isset($_POST['items']) && is_array($_POST['items'])) {
	        $i = 0;
	        foreach ($_POST['items'] as $item) {
	            $orden = ProductosEstrategicos::model()->findByPk($item);
	            //if($orden->orden != $i){
	            	$orden->orden = $i;
	            	$orden->save();
	            //}
	            $i++;
	        }
	    }
	    $this->layout = '//layouts/iframe'; 
        $this->render('orden', array(
            'model' => $model,
        	'tipoProducto'=> $id,	
        ));  
    }
            
	public function actionCreate() {
		$model = new ProductosEstrategicos;
		
		if (isset($_POST['ProductosEstrategicos'])) {
			$model->setAttributes($_POST['ProductosEstrategicos']);
			$relatedData = array(
				'objetivosEstrategicoses' => $_POST['ProductosEstrategicos']['objetivosEstrategicoses'] === '' ? null : $_POST['ProductosEstrategicos']['objetivosEstrategicoses'],
				'clientes' => $_POST['ProductosEstrategicos']['clientes'] === '' ? null : $_POST['ProductosEstrategicos']['clientes'],
				//'itemesPresupuestarioses' => $_POST['ProductosEstrategicos']['itemesPresupuestarioses'] === '' ? null : $_POST['ProductosEstrategicos']['itemesPresupuestarioses'],
				);

			if ($model->saveWithRelated($relatedData)) {
				/*if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('index', 'id' => $model->tipo_producto_id));*/
				echo CHtml::script("parent.cerrarModal();");
                Yii::app()->end();
			}
		}
		
        $modelSubproductos = TiposProductos::model()->find(array('condition'=>'estado=1 AND id='.$_GET['tipoProducto']));

        $tipoProducto=$modelSubproductos->nombre;
        $this->layout = '//layouts/iframe';
		$this->render('create', array( 'model' => $model,'nombreTipoProducto'=>$tipoProducto));
	}

	public function actionUpdate($id) {
	   // print_r(Yii::app()->user->checkAccess('updateProductosEstrategicos'));
	   //if(!Yii::app()->user->checkAccess('updateProductosEstrategicos'))
	   //if(AccessByCentroCosto())
        //    Yii::app()->end();
        
       // print_r($this->accessByCentroCosto($id));
		$model = $this->loadModel($id, 'ProductosEstrategicos');
		if (isset($_POST['ProductosEstrategicos'])) {
			$model->setAttributes($_POST['ProductosEstrategicos']);
			$relatedData = array(
				'objetivosEstrategicoses' => $_POST['ProductosEstrategicos']['objetivosEstrategicoses'] === '' ? null : $_POST['ProductosEstrategicos']['objetivosEstrategicoses'],
				'clientes' => $_POST['ProductosEstrategicos']['clientes'] === '' ? null : $_POST['ProductosEstrategicos']['clientes'],
				//'itemesPresupuestarioses' => $_POST['ProductosEstrategicos']['itemesPresupuestarioses'] === '' ? null : $_POST['ProductosEstrategicos']['itemesPresupuestarioses'],
				);

			if ($model->saveWithRelated($relatedData)){
				//$this->redirect(array('index', 'id' => $model->tipo_producto_id));
				echo CHtml::script("parent.cerrarModal();");
                Yii::app()->end();
			}
		}
        $modelSubproductos = TiposProductos::model()->find(array('condition'=>'id='.$_GET['tipoProducto']));
        $tipoProducto=$modelSubproductos->nombre;
        $this->layout = '//layouts/iframe';
		$this->render('update', array(
				'model' => $model,'nombreTipoProducto'=>$tipoProducto
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'ProductosEstrategicos')->delete();
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex($id) {
		$model = new ProductosEstrategicos('search');
        //$model->unsetAttributes();
        $modelSubproductos = TiposProductos::model()->find(array('condition'=>'estado= 1 AND id='.$id));
        
        $tipoProducto=$modelSubproductos->nombre;
        $this->render('index', array(
            'model' => $model,'tipoProducto'=>$tipoProducto,'tipo_producto_id'=>$id
        ));        
	}

	/*public function actionAdmin() {
		$model = new ProductosEstrategicos('search');
		$model->unsetAttributes();
        $model->tipo_producto_id=1; //ProductosEstrategicos[tipo_producto_id]=1
		if (isset($_GET['ProductosEstrategicos']))
			$model->setAttributes($_GET['ProductosEstrategicos']);

		$this->render('index', array(
			'model' => $model,
		));
	}*/
		

    /*protected function normalAccess($user,$rule)
    {
        //only allow if (authorID = userID) or (authorID <> userID and view_mode == public)
        $model = Flowbook::model()->find();
        $userID = Yii::app()->user->id;
        
        return ($userID === $model->author_id) ||  
        ($user !== $model->author_id && $model->view_mode === self::MODE_PUBLIC);            
    }*/
    
    public static function accessByCentroCosto($id)
    {
        //llamar a funcion de la siguiente manera: $this->accessByCentroCosto($id)
        //only allow if (authorID = userID) or (authorID <> userID and view_mode == public)
        $userID = Yii::app()->user->id;
        $modelSubproductos = Subproductos::model()->find(array('select'=>'centro_costo_id','condition'=>'producto_estrategico_id='.$id));
        $centroCostosUsuario=User::model()->with('centrosCostoses')->find(array('condition'=>'user.id='.$userID));
        $centroCostosUsuario = $centroCostosUsuario->centrosCostoses;
        
        return $centroCostosUsuario;
        
        return ($userID === $model->author_id) ||  
        ($user !== $model->author_id && $model->view_mode === self::MODE_PUBLIC);            
    }
    
}