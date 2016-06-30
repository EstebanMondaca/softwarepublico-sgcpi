<?php

class IndicadoresController extends GxController {

	
	/* *************************************************
	 * filters
	 * ------------------------------------------
	 * Realiza la llamada al control de acceso
	 * **************************************************/
	public function filters() {
     return array(
            'accessControl', 
            );
    }

	/* *************************************************
	 * accessRules
	 * ------------------------------------------
	 * Reglas del control de acceso 
	 * Permite las acciones a los roles y a las vistas solo al administrador
	 * **************************************************/
    public function accessRules() {

          return array( //checkAccessByCierre
            array('allow',
                'actions'=>array('index','view','obtenerProductos','obtenerProductosEspecificos','obtenerNombreUsuario','obtenerSubProductos','obtenerIndicador','obtenerUnidad'),                
                'roles'=>array('gestor','finanzas','supervisor','supervisor2'),//Solo usuarios autentificados (@ = para todos)
            ),
            array('allow',
                'actions'=>array('create','createnew'),                
                 'expression'=>'(Yii::app()->user->checkAccess("gestor") && (Yii::app()->user->checkAccessByCierre("IndicadoresController")))'
            ),
            array('allow',
                'actions'=>array('update','delete','updatenew'),                
                //Validamos si el usuario tiene permisos para editar como responsable del indicador
                //Si necesitamos agregar un rol diferente a admin, debemos ir a modificar la función checkAccessChange
                'expression'=>''.Yii::app()->user->checkAccessChange(array('modelName'=>'Indicadores','fieldName'=>'responsable_id','idRow'=>Yii::app()->getRequest()->getQuery("id"))),
           	),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
    
    /* *************************************************
	 * validateAccess
	 * ------------------------------------------
	 * 
	 * **************************************************/
     /*protected function validateAccess(){
        //echo $id;
        //Yii::app()->end();
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
    }*/
    /* *************************************************
	 * validateAccessbyIndicador
	 * ------------------------------------------
	 * 
	 * **************************************************/
     public static function validateAccessbyIndicador($idIndicador=0){
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
    }
    
    
    
    /* *************************************************
	 * actionView
	 * ------------------------------------------
	 * 
	 * **************************************************/
	public function actionView($id) {
		$nombreProducto=""; $centroCosto="";$centroResponsabilidad="";$nombreProductoEstrategico="";
		$nombreSubproducto="";
		
		$model = $this->loadModel($id, 'Indicadores');
		
		$hitosIndicadores = HitosIndicadores::model()->findAll(array('condition'=>'id_indicador='.$model->id));
	
		$userID = Yii::app()->user->id;
		
	//	$usuarioActivo = User::model()->find(array('condition'=>'id='.$userID));
	 //   $usuarioActivoConcatenado =	$usuarioActivo['nombres'].' '.$usuarioActivo['ape_paterno'].' '.$usuarioActivo['ape_materno'].' - '.$usuarioActivo['rut'];
		
	    
			$this->performAjaxValidation($model, 'indicadores-form');
			
			if(isset($model->producto_especifico_id)){
				//Traemos el producto asociado al ID 
				$productosEspecificos = ProductosEspecificos::model()->find(array('condition'=>'id='. $model->producto_especifico_id .' AND estado = 1'));
			 	
				$nombreProducto =	$productosEspecificos['nombre'];
			 	//Obtenemos el nombre
			 	$nombreSubproducto = $productosEspecificos->subproducto;
			 	//Obtenemos el nombre
			 	$nombreProductoEstrategico = $productosEspecificos->subproducto->productoEstrategico;
			 	
			 	//Para Obtener el centro de costo		 	
				$centroCosto = $productosEspecificos->subproducto->centroCosto;
				//Obtenemos el centro de responsabilidad 
				$centroResponsabilidad = $productosEspecificos->subproducto->centroCosto->division;
				
				$tipoProducto = TiposProductos::model()->find(array('condition'=>'id='. $nombreProductoEstrategico->tipo_producto_id .' AND estado = 1'));			
			}else{
			    $tipoProducto=array();
			}
		
		$this->layout = '//layouts/iframe';
		
		/*$this->render('view', array(
			'model' => $model,
		));*/
		
		$this->render('view', array(
				'model' => $model,
				'producto_especificoID' => $model->producto_especifico_id,//$id,
				'producto_especificoN' => $nombreProducto,
				'centroCosto' => $centroCosto,
				'centroResponsabilidad'=> $centroResponsabilidad,
				'nombreProductoEstrategico'=>$nombreProductoEstrategico,
				'nombreSubproducto'=>$nombreSubproducto,
			//	'usuarioActivoConcatenado'=>$usuarioActivoConcatenado,
				'hitosIndicadores' =>$hitosIndicadores,
				'tipoProducto'=>$tipoProducto,
				));
		
	}
	
    /* *************************************************
	 * getConcatened
	 * ------------------------------------------
	 * 
	 * **************************************************/
   public function getConcatened()
        {
  
          return Yii::app()->user->id.' '.Yii::app()->user->name;
        }
        
    /* *************************************************
	 * actionCreate
	 * ------------------------------------------
	 * 
	 * **************************************************/
	 
    public function actionCreatenew() {                      
        //Traemos todos los tipos de productos 
        //$tiposProductos = TiposProductos::model()->findAll(array('condition'=>'estado = 1'));
        $model = new Indicadores;       
        $userID = Yii::app()->user->id;
        $usuarioActivo = User::model()->find(array('condition'=>'id='.$userID));
        $usuarioActivoConcatenado = $usuarioActivo['nombres'].' '.$usuarioActivo['ape_paterno'].' '.$usuarioActivo['ape_materno'].' - '.$usuarioActivo['rut'];
        $this->layout = '//layouts/iframe'; 
        $this->performAjaxValidation($model, 'indicadores-form');
        $meses= array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre", "noviembre","diciembre");
        
        if (isset($_POST['Indicadores'])) {
        
            $model->setAttributes($_POST['Indicadores']);
            
            $relatedData = array('tiposIndicadores' => $_POST['Indicadores']['tiposIndicadores'] === '' ? null : $_POST['Indicadores']['tiposIndicadores'],
                );
                    
            if ($model->saveWithRelated($relatedData)) {
                
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                    
                else
                            
                    foreach ($meses as &$mes) {
                        if(isset($_POST['Indicadores'][$mes]))
                        {   
                            $metap= $_POST['Indicadores'][$mes];
                            if ($metap==NULL){
                                $metap = 0;
                            }
                            
                            $modelHitos = new HitosIndicadores;
                            
                            $modelHitos->mes=$mes;
                            //echo $mes;
                            $modelHitos->id_indicador=$model->id;
                            //$modelHitos->meta_parcial= $_POST['Indicadores'][$mes];
                            $modelHitos->meta_parcial=$metap;
                            //$modelHitos->save();
                            $modelHitos->save(false); 
                        }
                    }           
                    //$this->redirect(array('view', 'id' => $model->id));
                    echo CHtml::script("parent.indicadorAlmacenadoDesdeLineasDeAccion(".$model->id.");");
                    Yii::app()->end();
            }
            
            

        }
        $this->render('createnew', array(            
            //'tiposProductos' => $tiposProductos,
            'model' => $model,
            'producto_especificoID' => null,
            'producto_especificoN' => null,
            'centroCosto' => null,
            'centroResponsabilidad'=> null,
            'nombreProductoEstrategico'=>null,
            'nombreSubproducto'=>null,
            'usuarioActivoConcatenado'=>$usuarioActivoConcatenado,                      
        ));           
    }
    
    /*public function actionUpdatenew($id) {
        $model = $this->loadModel($id, 'Indicadores');
              
        $userID = Yii::app()->user->id;
        $usuarioActivo = User::model()->find(array('condition'=>'id='.$userID));
        $usuarioActivoConcatenado = $usuarioActivo['nombres'].' '.$usuarioActivo['ape_paterno'].' '.$usuarioActivo['ape_materno'].' - '.$usuarioActivo['rut'];
        $this->layout = '//layouts/iframe'; 
        $this->performAjaxValidation($model, 'indicadores-form');
        
        
        if (isset($_POST['Indicadores'])) {
        
            $model->setAttributes($_POST['Indicadores']);
            
            $relatedData = array('tiposIndicadores' => $_POST['Indicadores']['tiposIndicadores'] === '' ? null : $_POST['Indicadores']['tiposIndicadores'],
                );
                    
            if ($model->saveWithRelated($relatedData)) {
                
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                    
                else
                            
                    foreach ($meses as &$mes) {
                        if(isset($_POST['Indicadores'][$mes]))
                        {
                            //print_r ($_POST['Indicadores'][$mes]);
                            $modelHitos = new HitosIndicadores;
                            
                            $modelHitos->mes=$mes;
                            $modelHitos->id_indicador=$model->id;
                            $modelHitos->meta_parcial= $_POST['Indicadores'][$mes];
                            $modelHitos->save();
                        }
                    }           
                    //$this->redirect(array('view', 'id' => $model->id));
                    if(isset($_GET['referer'])){
                        //cuando exista el referer debemos validar su procedencia
                        if($_GET['referer']=='lineasdeaccion'){
                            echo CHtml::script("parent.parent.indicadorAlmacenadoDesdeLineasDeAccion(".$model->id.");");
                            Yii::app()->end();
                        }
                    }
                    echo CHtml::script("parent.cerrarModal();");
                    Yii::app()->end();
            }
            
            

        }
        $this->render('createnew', array(            
            //'tiposProductos' => $tiposProductos,
            'model' => $model,
            'producto_especificoID' => null,
            'producto_especificoN' => null,
            'centroCosto' => null,
            'centroResponsabilidad'=> null,
            'nombreProductoEstrategico'=>null,
            'nombreSubproducto'=>null,
            'usuarioActivoConcatenado'=>$usuarioActivoConcatenado,                      
        ));           
    }
    */
    public function actionCreate($id) {
		$model = new Indicadores;		
				
		$meses= array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre", "noviembre","diciembre");
	
		$userID = Yii::app()->user->id;
		
		$usuarioActivo = User::model()->find(array('condition'=>'id='.$userID));
	    $usuarioActivoConcatenado =	$usuarioActivo['nombres'].' '.$usuarioActivo['ape_paterno'].' '.$usuarioActivo['ape_materno'].' - '.$usuarioActivo['rut'];
		
        $model->producto_especifico_id=$id;

		

		$this->performAjaxValidation($model, 'indicadores-form');

		$nombreProducto = "";

		if (isset($id)) {

			//Traemos el producto asociado al ID 
			$productosEspecificos = ProductosEspecificos::model()->find(array('condition'=>'id='.$id.' AND estado = 1'));
 				
			$nombreProducto =	$productosEspecificos['nombre'];
		 	//Obtenemos el nombre
		 	$nombreSubproducto = $productosEspecificos->subproducto;
		 	//Obtenemos el nombre
		 	$nombreProductoEstrategico = $productosEspecificos->subproducto->productoEstrategico;		 	
		 	//Para Obtener el centro de costo		 	
			$centroCosto = $productosEspecificos->subproducto->centroCosto;
			//Obtenemos el centro de responsabilidad 
			$centroResponsabilidad = $productosEspecificos->subproducto->centroCosto->division;			//NOTA: debe irse a buscar al producto estrategico
		}
        
		if (isset($_POST['Indicadores'])) {
		
			$model->setAttributes($_POST['Indicadores']);
			
			$relatedData = array('tiposIndicadores' => $_POST['Indicadores']['tiposIndicadores'] === '' ? null : $_POST['Indicadores']['tiposIndicadores'],
				);
					


			if ($model->saveWithRelated($relatedData)) {
				
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
					
				else
							
					foreach ($meses as &$mes) {
		    			if(isset($_POST['Indicadores'][$mes]))
		    			{
		    				//print_r ($_POST['Indicadores'][$mes]);
		    				$metap= $_POST['Indicadores'][$mes];
		    				if ($metap==NULL){
		    					$metap = 0;
		    				}
		    				
		    				$modelHitos = new HitosIndicadores;
		    				
		    				$modelHitos->mes=$mes;
		    				//echo $mes;
		    				$modelHitos->id_indicador=$model->id;
		    				//$modelHitos->meta_parcial= $_POST['Indicadores'][$mes];
		    				$modelHitos->meta_parcial=$metap;
		    				//$modelHitos->save();
		    				$modelHitos->save(false); 
		    			}
					}
								
					//$this->redirect(array('view', 'id' => $model->id));
					if(isset($_GET['referer'])){
					    //cuando exista el referer debemos validar su procedencia
					    if($_GET['referer']=='lineasdeaccion'){
					        echo CHtml::script("parent.parent.indicadorAlmacenadoDesdeLineasDeAccion(".$model->id.");");
                            Yii::app()->end();
					    }
					}
					echo CHtml::script("parent.cerrarModal();");
					Yii::app()->end();
			}
			
			

		}
		$this->layout = '//layouts/iframe';	
		$this->render('create', array( 
			'model' => $model,
			'producto_especificoID' => $id,
			'producto_especificoN' => $nombreProducto,
			'centroCosto' => $centroCosto,
			'centroResponsabilidad'=> $centroResponsabilidad,
			'nombreProductoEstrategico'=>$nombreProductoEstrategico,
			'nombreSubproducto'=>$nombreSubproducto,
			'usuarioActivoConcatenado'=>$usuarioActivoConcatenado,
		));
	}
	
    /* *************************************************
	 * actionUpdate
	 * ------------------------------------------
	 * 
	 * **************************************************/	
	 
	 public function actionUpdatenew($id) {
        $model = $this->loadModel($id, 'Indicadores');
        
        $hitosIndicadores = HitosIndicadores::model()->findAll(array('condition'=>'id_indicador='.$model->id));
            
        $meses= array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre", "noviembre","diciembre");
    
        $userID = Yii::app()->user->id;
        
        $usuarioActivo = User::model()->find(array('condition'=>'id='.$userID));
        $usuarioActivoConcatenado = $usuarioActivo['nombres'].' '.$usuarioActivo['ape_paterno'].' '.$usuarioActivo['ape_materno'].' - '.$usuarioActivo['rut'];
        
        
        $this->performAjaxValidation($model, 'indicadores-form');
        
        
        if (isset($_POST['Indicadores'])) {
            $model->setAttributes($_POST['Indicadores']);
            $relatedData = array(
                'tiposIndicadores' => $_POST['Indicadores']['tiposIndicadores'] === '' ? null : $_POST['Indicadores']['tiposIndicadores'],
                );

            if ($model->saveWithRelated($relatedData)) {
                foreach ($meses as &$mes) {
                
                    if(isset($_POST['Indicadores'][$mes]))
                    {
                        
                        $modelHitos=HitosIndicadores::model()->find(
                            "id_indicador=".$id." AND mes='".$mes."' AND estado=1"
                        );
                        
                        if($modelHitos){//En caso de existir el registro en la DB, realizaremos un update
                            $modelHitos->meta_parcial = $_POST['Indicadores'][$mes];
                            $modelHitos->update();
                        }else{
                            $modelHitos = new HitosIndicadores;                            
                            $modelHitos->mes=$mes;
                            $modelHitos->id_indicador=$model->id;
                            $modelHitos->meta_parcial= $_POST['Indicadores'][$mes];
                            $modelHitos->save(false); 
                        } 
                    }
    
                }

                //Cambiando al responsable de la AMI/LA en caso de existir.
                if(isset($model->lineasAccions[0]) && isset($_POST['Indicadores']['responsable_id']) && Yii::app()->user->checkAccess("admin")){
                    if(isset($model->lineasAccions[0]->id)){
                        if($model->lineasAccions[0]->id!=$_POST['Indicadores']['responsable_id'] && is_numeric($_POST['Indicadores']['responsable_id']) && is_numeric($model->lineasAccions[0]->id)){
                            $responsable=LineasAccion::model()->findbypk($model->lineasAccions[0]->id);
                            $responsable->id_responsable_implementacion=$_POST['Indicadores']['responsable_id'];
                            $responsable->save(false);                            
                            echo CHtml::script("parent.$('#LineasAccion_id_responsable_implementacion').val(".$_POST['Indicadores']['responsable_id'].");");
                            echo CHtml::script("parent.$('#nombreResponsableLA').html('".$responsable->idResponsableImplementacion->nombrecompleto."');");                            
                        }                        
                    }
                }
                echo CHtml::script("parent.indicadorAlmacenadoDesdeLineasDeAccion(".$model->id.");");
                Yii::app()->end();
          }          
        }
    

            //Traemos el producto asociado al ID 
            $lineaAccion = LineasAccion::model()->find(array('condition'=>'id_indicador='. $model->id .' AND estado = 1'));
            
            $nombreProducto =  ''; //$productosEspecificos['nombre'];
            //Obtenemos el nombre
           // $nombreSubproducto = $productosEspecificos->subproducto;
            //Obtenemos el nombre
            if($lineaAccion){
                $nombreProductoEstrategico = $lineaAccion->productoEstrategico;            
                //Para Obtener el centro de costo           
                $centroCosto = $lineaAccion->centroCosto;
                //Obtenemos el centro de responsabilidad 
                $centroResponsabilidad = $lineaAccion->centroCosto->division;
            }else{
                $nombreProductoEstrategico=$centroCosto=$centroResponsabilidad=null;
            }
            
            
            
            

        
        $this->layout = '//layouts/iframe';
        
         //$permiteSoloVisualizar = TRUE;
         $permiteSoloVisualizar=!Yii::app()->user->checkAccessChange(array('modelName'=>'Indicadores','fieldName'=>'responsable_id','idRow'=>$id));
         /*if(IndicadoresController::validateAccessbyIndicador($id)){
            $permiteSoloVisualizar = FALSE;
         }*/
        
        $this->render('update', array(
                'model' => $model,
                'producto_especificoID' => null,
                'producto_especificoN' => null,
                'centroCosto' => $centroCosto,
                'centroResponsabilidad'=> $centroResponsabilidad,
                'nombreProductoEstrategico'=>$nombreProductoEstrategico,
                'nombreSubproducto'=>null,
                'usuarioActivoConcatenado'=>$usuarioActivoConcatenado,  
                'hitosIndicadores' =>$hitosIndicadores,
                'permiteSoloVisualizar'=>$permiteSoloVisualizar,
                ));  
    }
	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Indicadores');
		
		$hitosIndicadores = HitosIndicadores::model()->findAll(array('condition'=>'id_indicador='.$model->id));
			
		$meses= array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre", "noviembre","diciembre");
	
		$userID = Yii::app()->user->id;
		
		$usuarioActivo = User::model()->find(array('condition'=>'id='.$userID));
	    $usuarioActivoConcatenado =	$usuarioActivo['nombres'].' '.$usuarioActivo['ape_paterno'].' '.$usuarioActivo['ape_materno'].' - '.$usuarioActivo['rut'];
		
	    
		$this->performAjaxValidation($model, 'indicadores-form');
		
		
		if (isset($_POST['Indicadores'])) {
			$model->setAttributes($_POST['Indicadores']);
			$relatedData = array(
				'tiposIndicadores' => $_POST['Indicadores']['tiposIndicadores'] === '' ? null : $_POST['Indicadores']['tiposIndicadores'],
				);

			if ($model->saveWithRelated($relatedData)) {
			    foreach ($meses as &$mes) {
		    	
			    	if(isset($_POST['Indicadores'][$mes]))
			    	{
			    		
			    		$modelHitos=HitosIndicadores::model()->find(
			    			"id_indicador=".$id." AND mes='".$mes."' AND estado=1"
			    		);
                        
                        if($modelHitos){//En caso de existir el registro en la DB, realizaremos un update
                            $modelHitos->meta_parcial = $_POST['Indicadores'][$mes];
                            $modelHitos->update();
                        }else{
                            $modelHitos = new HitosIndicadores;
                            
                            $modelHitos->mes=$mes;
                            $modelHitos->id_indicador=$model->id;
                            $modelHitos->meta_parcial= $_POST['Indicadores'][$mes];
                            $modelHitos->save(false); 
                        }
			    	}
	
				}
                echo CHtml::script("parent.cerrarModal();");
                Yii::app()->end();
		  }		  
		}
	

			//Traemos el producto asociado al ID 
			$productosEspecificos = ProductosEspecificos::model()->find(array('condition'=>'id='. $model->producto_especifico_id .' AND estado = 1'));
		 	
			$nombreProducto =	$productosEspecificos['nombre'];
		 	//Obtenemos el nombre
		 	$nombreSubproducto = $productosEspecificos->subproducto;
		 	//Obtenemos el nombre
		 	$nombreProductoEstrategico = $productosEspecificos->subproducto->productoEstrategico;
		 	
		 	//Para Obtener el centro de costo		 	
			$centroCosto = $productosEspecificos->subproducto->centroCosto;
			//Obtenemos el centro de responsabilidad 
			$centroResponsabilidad = $productosEspecificos->subproducto->centroCosto->division;
			
			
			

		
		$this->layout = '//layouts/iframe';
		
		 /*$permiteSoloVisualizar = TRUE;
		 
		 if(IndicadoresController::validateAccessbyIndicador($id)){
		 	$permiteSoloVisualizar = FALSE;
		 }*/
		 $permiteSoloVisualizar=!Yii::app()->user->checkAccessChange(array('modelName'=>'Indicadores','fieldName'=>'responsable_id','idRow'=>$id));
		
		$this->render('update', array(
				'model' => $model,
				'producto_especificoID' => $model->producto_especifico_id,//$id,
				'producto_especificoN' => $nombreProducto,
				'centroCosto' => $centroCosto,
				'centroResponsabilidad'=> $centroResponsabilidad,
				'nombreProductoEstrategico'=>$nombreProductoEstrategico,
				'nombreSubproducto'=>$nombreSubproducto,
				'usuarioActivoConcatenado'=>$usuarioActivoConcatenado,
				'hitosIndicadores' =>$hitosIndicadores,
				'permiteSoloVisualizar'=>$permiteSoloVisualizar,
				));
	}

    /* *************************************************
	 * actionDelete
	 * ------------------------------------------
	 * 
	 * **************************************************/
	public function actionDelete($id) {
			//echo "DELETE";
			//echo $id;
			
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			//echo "entro";
			$this->loadModel($id, 'Indicadores')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Requerimiento invalido.'));
				
	}

    /* *************************************************
	 * actionIndex
	 * ------------------------------------------
	 * 
	 * **************************************************/
	public function actionIndex() {
	
		$model = new Indicadores('search');
		$model->unsetAttributes();
		
		//Traemos todos los productos estrategicos
		//$productosEstrategicos = ProductosEstrategicos::model()->findAll();

		//Traemos todos los tipos de productos 
		$tiposProductos = TiposProductos::model()->findAll(array('condition'=>'estado = 1'));
		
		if (isset($_GET['Indicadores'])){
			$model->setAttributes($_GET['Indicadores']);
		}
    	
		$this->render('index', array(
			
			'tiposProductos' => $tiposProductos,
			'model' => $model,
			//'productosEstrategicos' => $productosEstrategicos,
		));
	}


	/*****************************************************************************
	 * actionObtenerSubproductos
	 * --------------------------
	 * Permite buscar dentro de los sub productos el identificador del
	 * producto estrategico seleccionado.
	 * 
	 * ----------
	 * $idProductosEstrategicos = Identificador unico de productos estrategicos
	 * $centro_costo_id =FALTA PASARLE ESTE PAMETRO
	 ****************************************************************************/
	public function actionObtenerSubProductos($id){
		
		$subProductos = Subproductos::model()->findAll(array('condition'=>'producto_estrategico_id = '.$id.' AND estado = 1') );
		header("Content-type: application/json");
		echo CJSON::encode($subProductos);
	}
	/*****************************************************************************
	 * actionObtenerProductos
	 * --------------------------
	 * 
	 ****************************************************************************/
	public function actionObtenerProductos($id){
		

        //$criteria->select = 'mes, meta_parcial , meta_reportada';
        //$criteria->addCondition('estado = 1 AND id = '.$id_indicador);
       // $indicadores = HitosIndicadores::model()->findAll($criteria);
        
        
		
		$criteria = new CDbCriteria;
		$criteria->join='
                INNER JOIN objetivos_productos op ON t.id = op.producto_estrategico_id
                INNER JOIN objetivos_estrategicos oe ON op.objetivo_estrategico_id = oe.id
                INNER JOIN desafios_objetivos do2 ON  oe.id = do2.objetivo_estrategico_id
                INNER JOIN desafios_estrategicos de ON do2.desafio_estrategico_id = de.id
                INNER JOIN planificaciones pl ON de.planificacion_id = pl.id 
                INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id';
            $criteria->distinct =true;
            $criteria->select='t.*';
			$criteria->addCondition('t.tipo_producto_id = '.$id.' AND t.estado =1 AND pp.id = '.Yii::app()->session['idPeriodo']);
 	
		  $productos = ProductosEstrategicos::model()->findAll($criteria);
		
		header("Content-type: application/json");
		echo CJSON::encode($productos);
	
	}
	
	 /* *************************************************
	 * actionObtenerProductosEspecificos
	 * ------------------------------------------
	 * 
	 * **************************************************/
	public function actionObtenerProductosEspecificos($id){
		//
		
		$productosEspecificos = ProductosEspecificos::model()->findAll(array('condition'=>'subproducto_id = '.$id.' AND estado = 1') );
		header("Content-type: application/json");
		echo CJSON::encode($productosEspecificos);
	}
	
    public function actionObtenerIndicador($id){        
        $indicador = Indicadores::model()->findAll(array('select'=>'t.descripcion,t.medio_verificacion,t.meta_anual,fc.nombre','join'=>'inner join frecuencias_controles fc on t.frecuencia_control_id=fc.id','condition'=>'t.id = '.$id.' AND t.estado = 1'));
        header("Content-type: application/json");
        echo CJSON::encode($indicador);
    }
    
    /* *************************************************
	 * actionObtenerNombreUsuario
	 * ------------------------------------------
	 * 
	 * **************************************************/
	public function obtenerNombreUsuario($id){
		
		$usuarioActivo = User::model()->find(array('condition'=>'id='.$id));
	    $usuarioActivoConcatenado =	$usuarioActivo['nombres'].' '.$usuarioActivo['ape_paterno'].' '.$usuarioActivo['ape_materno'].' - '.$usuarioActivo['rut'];
		return $usuarioActivoConcatenado;
	}	
	public function gridDataBreakText($data) {
	
		$string =  $data;
	
		$phrase_array = explode(' ',$data);
	
		if(count($phrase_array) < 30 ){
			if(strlen($string) > 90) {
	
				$string = substr($string, 0, 85);
				if(false !== ($breakpoint = strrpos($string, '\n'))) { $string = substr($string, 0, $breakpoint); }
				return $string . '...';
					
			}
		}
		return $string;
	}

    public function actionObtenerUnidad($id){        
        $formula = TiposFormulas::model()->find(array('condition'=>'id='.$id));
     //  echo  $formula->unidad;
        header("Content-type: application/json");
       // echo CJSON::encode( $formula->unidad);
       	
        echo CJSON::encode(array('unidad'=>$formula->unidad,'formula'=>$formula->formula) );
    }





}
