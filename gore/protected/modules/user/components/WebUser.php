<?php

class WebUser extends CWebUser
{

    public function getRole()
    {
        return $this->getState('__role');
    }
    
    public function getId()
    {
        return $this->getState('__id') ? $this->getState('__id') : 0;
    }

//    protected function beforeLogin($id, $states, $fromCookie)
//    {
//        parent::beforeLogin($id, $states, $fromCookie);
//
//        $model = new UserLoginStats();
//        $model->attributes = array(
//            'user_id' => $id,
//            'ip' => ip2long(Yii::app()->request->getUserHostAddress())
//        );
//        $model->save();
//
//        return true;
//    }

    protected function afterLogin($fromCookie)
	{
        parent::afterLogin($fromCookie);
        $this->updateSession();
	}

    public function updateSession() {
        $user = Yii::app()->getModule('user')->user($this->id);
        //Rceballos:: El controller de profile del usuario no se está ocupoando, no es necesario realizar un merge de un array.
        /*$userAttributes = CMap::mergeArray(array(
                                                'email'=>$user->email,
                                                'username'=>$user->username,
                                                'create_at'=>$user->create_at,
                                                'lastvisit_at'=>$user->lastvisit_at,
                                           ),$user->profile->getAttributes());*/
        
        $userAttributes = array(
                                                'email'=>$user->email,
                                                'username'=>$user->username,
                                                'create_at'=>$user->create_at,
                                                'lastvisit_at'=>$user->lastvisit_at,
                                           );                              
        foreach ($userAttributes as $attrName=>$attrValue) {
            $this->setState($attrName,$attrValue);
        }
    }

    public function model($id=0) {
        return Yii::app()->getModule('user')->user($id);
    }

    public function user($id=0) {
        return $this->model($id);
    }

    public function getUserByName($username) {
        return Yii::app()->getModule('user')->getUserByName($username);
    }

    public function getAdmins() {
        return Yii::app()->getModule('user')->getAdmins();
    }

    public function isAdmin() {
        return Yii::app()->getModule('user')->isAdmin();
    }
    
    
    public function checkAccessByCierre($controllerName){
        if(Yii::app()->user->checkAccess("admin")){
            return true;
        }
        $listadoAccesos=array();
        $u_today = date('Y-m-d');
        $listadoAccesos['procesoPlanificacionInstitucional']=array('desafiosEstrategicosController','MisionesVisionesController','objetivosEstrategicosController','productosEstrategicosController','SubproductosController','elementosGestionPriorizadosController','elementosGestionResponsableController','indicadoresController','lineasAccionController','ElementosGestionController','indicadoresInstrumentosController','actividadesController','presupuestoCentrosCostosController');
        $listadoAccesos['procesoControlGestion']=array('panelAvancesController','controlElementosGestionController','ejecucionPresupuestariaController');
        $listadoAccesos['evaluacionGestion']=array('evaluacionJornadaController','evaluacionElementosGestionController');
        
        $acceso='';
        $accesoReal='';
        //Recuperando proceso Macro del controlador
        foreach($listadoAccesos as $key=>$value){
            foreach($value as $k=>$v){
                if(strtoupper($v)==strtoupper($controllerName)){
                    $acceso=$key;
                }
                if(strtoupper(Yii::app()->controller->id.'Controller')!=strtoupper($controllerName)){
                    if(strtoupper($v)==strtoupper(Yii::app()->controller->id.'Controller')){
                        $accesoReal=$key;
                    }
                }
            }
        } 
              
        if($acceso!="" || $accesoReal!=""){
            $activacion=ActivacionProceso::model()->findAll(array('condition'=>'nombre_contenedor="'.$acceso.'"AND inicio < "'.$u_today.'" AND fin > "'.$u_today.'" AND periodo_id='.Yii::app()->session['idPeriodo']));            
            if(isset($activacion[0])){
                return true;
            }else{
                $activacion=ActivacionProceso::model()->findAll(array('condition'=>'nombre_contenedor="'.$accesoReal.'"AND inicio < "'.$u_today.'" AND fin > "'.$u_today.'" AND periodo_id='.Yii::app()->session['idPeriodo']));
                if(isset($activacion[0])){
                    return true;
                }
            }
        }

        return false;        
        
    }
    //$controllerName="Nombre de controlador a consultar"
    //$action="Nombre de la accion a validar el acceso para el usuario actual"
    public function checkAccessChangeDataGore($controllerName='',$validateRow=array(),$actionName='update') {
        $executeAction=false;
        if($controllerName=='') return $executeAction;
        $controller = new $controllerName('accessRules');
                     
        foreach($controller->accessRules() as $key=>$v){
            //Si la funcion permite el acceso debemos validar si el usuario actual está dentro de los permisos para ingresar/editar/eliminar        
            if (array_key_exists('actions', $v) && array_key_exists('roles', $v)){
                if (in_array($actionName, $v['actions'])){
                     //Debemos verificar si nosotros tenemos acceso a los roles
                     foreach($v['roles'] as $rol){
                         if(Yii::app()->user->checkAccess($rol)){
                             $executeAction=true;
                         }
                     }
                }
            }
        }        
        //En caso de no tener asignado su rol para editar, debemos buscar si la asignación está a nivel de responsable.
        if(count($validateRow)>0 && !$executeAction){
            
            if(!Yii::app()->user->checkAccessByCierre($controllerName)){
                return $executeAction;
            }
            
            //Procederemos a validar el acceso a un responsable            
            $modelName=$validateRow['modelName'];
            $idRow=$validateRow['idRow'];
            if($idRow==null)
                    $idRow=0;            
            $owner_id=null;
            $model = $modelName::model()->findAll(array('condition'=>'t.estado=1 AND t.id='.$idRow));
            $fieldName=$validateRow['fieldName'];
            //Para multiples campos
            if(is_array($fieldName)){
                //En caso de existir mas de un campo como responsable en la tabla.
                foreach($fieldName as $k=>$v){
                    if(isset($model[0]->$v)){
                        $owner_id=$model[0]->$v;
                    }
                    //Verificando si el usuario tiene permisos para acceder o si es admin     
                    $executeAction=(Yii::app()->user->id === $owner_id);
                    if($executeAction)   
                        return $executeAction;                 
                }                
            }else{                            
                if(isset($model[0]->$fieldName)){
                    $owner_id=$model[0]->$fieldName;
                }
                //Verificando si el usuario tiene permisos para acceder o si es admin     
                $executeAction=(Yii::app()->user->id === $owner_id);
            }
            
        }
        
        return $executeAction;
    }
    //Permite validar sin utilizar el accessRoles, sólo valida que el usuario sea administrador o que tenga un campo
    //asociado a un responsable para poder editar/crear/eliminar
    public function checkAccessChange($validateRow=array()) {
        $executeAction=false;
        
        //En caso de no tener asignado su rol para editar, debemos buscar si la asignación está a nivel de responsable.
       if(Yii::app()->user->checkAccess("admin")){       	
               $executeAction=true;
       }else{
           if(count($validateRow)>0){               
                //Procederemos a validar el acceso a un responsable            
                $modelName=$validateRow['modelName'];
                $fieldName=$validateRow['fieldName'];                
                $idRow=$validateRow['idRow']; 
                if(isset($validateRow['from'])){
                    if(!Yii::app()->user->checkAccessByCierre($validateRow['from'].'Controller')){                    
                        return $executeAction;
                    }
                }else{
                    if(!Yii::app()->user->checkAccessByCierre($modelName.'Controller')){                    
                        return $executeAction;
                    }
                }
                
                
                if($idRow==null)
                    $idRow=0;    
                
                $owner_id=null;    
                $model = $modelName::model()->findAll(array('condition'=>'t.estado=1 AND t.id='.$idRow));                
                
                $fieldName = explode("->", $fieldName);
                if(is_array($fieldName)){                    
                    //En caso de existir relaciones a otras tablas.
                    if(isset($model[0])){
                        $owner_id=$model[0];
                        //print_r($owner_id->relations());                       
                        foreach($fieldName as $k=>$v){
                            //print_r($model[0]->$v);                                                                                                              
                            if(isset($owner_id->$v)){                                                                
                                $owner_id=$owner_id->$v;     
                            }
                        }
                    }
                }else{                            
                    if(isset($model[0]->$fieldName)){
                        $owner_id=$model[0]->$fieldName;
                    }
                }
                 
                /*if(isset($owner_id)){
                    echo "user".$owner_id[0]->responsable_id;
                    foreach($owner_id as $v){
                        echo ",User=".$v->responsable_id;
                    }
                }*/
                //Verificando si el usuario tiene permisos para acceder o si es admin     
                $executeAction=(Yii::app()->user->id === $owner_id);
             }       
       }         
        return $executeAction;
    }

    //Permite validar sin utilizar el accessRoles, sólo valida que el usuario sea administrador o que tenga un campo
    //asociado a un responsable para la tabla de elementos de gestión vs elementos de gestion con responsable editar/crear/eliminar
    public function checkAccessChangeFromElementosDeGestionSegunCC($validateRow=array()) {
        $executeAction=false;
        
        //En caso de no tener asignado su rol para editar, debemos buscar si la asignación está a nivel de responsable.
       if(Yii::app()->user->checkAccess("admin")){          
               $executeAction=true;
       }else{
           if(count($validateRow)>0){               
                //Procederemos a validar el acceso a un responsable            
                $modelName=$validateRow['modelName'];                
                $idRow=$validateRow['idRow']; 
                if(isset($validateRow['from'])){
                    if(!Yii::app()->user->checkAccessByCierre($validateRow['from'].'Controller')){                    
                        return $executeAction;
                    }
                }else{
                    if(!Yii::app()->user->checkAccessByCierre($modelName.'Controller')){                    
                        return $executeAction;
                    }
                }
                
                
                if($idRow==null)
                    $idRow=0;    
                
                $owner_id=null;    
                $model = $modelName::model()->findAll(array('condition'=>'t.estado=1 AND t.id='.$idRow));                
                
                if(isset($model[0])){
                   if(isset($model[0]->elementosGestionResponsables[0]))
                    if(isset($model[0]->elementosGestionResponsables[0]->responsable_id))
                           $owner_id=$model[0]->elementosGestionResponsables[0]->responsable_id;
                }
                
                //Verificando si el usuario tiene permisos para acceder o si es admin     
                $executeAction=(Yii::app()->user->id === $owner_id);
             }       
       }         
        return $executeAction;
    }

    public function checkAccessChangeByCentroCostoFromElementosGestion($validateRow=array()) {
        $executeAction=false;
        
           if(count($validateRow)>0){               
                //Procederemos a validar el acceso a un responsable            
                $modelName=$validateRow['modelName'];             
                $idRow=$validateRow['idRow'];                               
                
                if($idRow==null)
                    $idRow=0;    

                $centro_costo_id=0;    
                $model = $modelName::model()->findAll(array('condition'=>'t.estado=1 AND t.id='.$idRow));                
                
                                            
                if(isset($model[0])){
                    if(isset($model[0]->elementosGestionResponsables[0])){
                        if(isset($model[0]->elementosGestionResponsables[0]->centro_costo_id)){
                            $centro_costo_id=$model[0]->elementosGestionResponsables[0]->centro_costo_id;
                        } 
                    }
                }
                
                $centroCosto=User::model()->with('centrosCostoses')->findAll(array('condition'=>'user.id='.Yii::app()->user->id.' AND centrosCostoses.estado=1 AND centrosCostoses.id='.$centro_costo_id));
                
                if($centroCosto){
                    $executeAction=true;
                }
        }       
                
        return $executeAction;
    }

    public function checkAccessChangeByCentroCostoFromIndicadores($validateRow=array()) {
        $executeAction=false;
        
           if(count($validateRow)>0){               
                //Procederemos a validar el acceso a un responsable            
                $modelName=$validateRow['modelName'];
                $fieldName=$validateRow['fieldName'];                
                $idRow=$validateRow['idRow'];                            
                
                if($idRow==null)
                    $idRow=0;    
                
                /*if(!Yii::app()->user->checkAccessByCierre($modelName.'Controller')){                    
                        return $executeAction;
                }*/
                $centro_costo_id=0;  
                $model = $modelName::model()->findAll(array('condition'=>'t.estado=1 AND t.id='.$idRow));                
                
                $fieldName = explode("->", $fieldName);
                if(is_array($fieldName)){              
                    //En caso de existir relaciones a otras tablas.
                    if(isset($model[0])){
                        $centro_costo_id=$model[0];                                          
                        foreach($fieldName as $k=>$v){                                                                                                                                                                    
                            if(isset($centro_costo_id->$v)){                                                                
                                $centro_costo_id=$centro_costo_id->$v;     
                            }
                        }
                       // print_r($centro_costo_id);
                    }
                }else{                            
                    if(isset($model[0]->$fieldName)){
                        $centro_costo_id=$model[0]->$fieldName;
                    }
                }
                
                if(!is_numeric($centro_costo_id)){
                    $centro_costo_id=0; 
                }
                
                $centroCosto=User::model()->with('centrosCostoses')->findAll(array('condition'=>'user.id='.Yii::app()->user->id.' AND centrosCostoses.estado=1 AND centrosCostoses.id='.$centro_costo_id));
                
                if($centroCosto){
                    $executeAction=true;
                }
        }       
                
        return $executeAction;
    }
}