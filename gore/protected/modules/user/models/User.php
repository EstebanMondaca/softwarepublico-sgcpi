<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;

	
	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED=-1;
	
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
     * @var string $nombres
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableUsers;
	}
    
   
    public static function label($n = 1) {
        return Yii::t('app', 'Usuario|Usuarios', $n);
    }
    
    public static function representingColumn() {
        return 'username';
    }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		return ((get_class(Yii::app())=='CConsoleApplication' || (get_class(Yii::app())!='CConsoleApplication' && Yii::app()->getModule('user')->isAdmin()))?array(
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Nombre de usuario incorrecto (El largo debe estar entre 3 y 10 caracteres).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Contraseña incorrecta (El largo debe ser minimo de 4 caracteres).")),
			array('email', 'email','message'=>UserModule::t('El correo electrónico no es una dirección válida.')),
			array('username', 'unique', 'message' => UserModule::t("El nombre de usuario ingresado ya existe.")),
			//array('email', 'unique', 'message' => UserModule::t("El email ingresado ya existe")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Sólo puede utilizar los siguientes caracteres (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE)),//,self::STATUS_BANNED
			array('superuser', 'in', 'range'=>array(0,1)),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			array('username, email, status,cargo_id,nombres, ape_paterno, authItems,centrosCostoses,password', 'required'),
			array('rut', 'length', 'max'=>10),
			array('nombres, ape_paterno, ape_materno', 'length', 'max'=>200),
			array('superuser, status,cargo_id,estado','numerical', 'integerOnly'=>true),
			array('id, username, password, email,estado, activkey, create_at, lastvisit_at, superuser, status,cargo_id', 'safe', 'on'=>'search'),
		):((Yii::app()->user->id==$this->id)?array(
			array('username, email,cargo_id,nombres, ape_paterno, authItems,centrosCostoses,password', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Nombre de usuario incorrecto (El largo debe estar entre 3 y 10 caracteres.).")),
			array('email', 'email'),
			array('rut', 'length', 'max'=>10),
            array('nombres, ape_paterno, ape_materno', 'length', 'max'=>200),
			array('username', 'unique', 'message' => UserModule::t("El nombre de usuario ingresado ya existe.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Sólo puede utilizar los siguientes caracteres (A-z0-9).")),
			array('email', 'unique', 'message' => UserModule::t("El email ingresado ya existe.")),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        $relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile']))
            $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');        
        
        $relations['authItems'] = array(self::MANY_MANY, 'AuthItem', 'AuthAssignment(userid, itemname)');
        $relations['centrosCostoses'] = array(self::MANY_MANY, 'CentrosCostos', 'users_centros(user_id, centro_id)');
        $relations['cargo'] = array(self::BELONGS_TO, 'Cargos', 'cargo_id');
        $relations['indicadores'] = array(self::HAS_MANY, 'Indicadores', 'responsable_id');
        $relations['lineasAccions'] = array(self::MANY_MANY, 'LineasAccion', 'la_actores(id_usuario, id_la)');
        $relations['lineasAccions1'] = array(self::HAS_MANY, 'LineasAccion', 'id_responsable_implementacion');
        $relations['lineasAccions2'] = array(self::HAS_MANY, 'LineasAccion', 'id_responsable_mantencion');
        $relations['cierresInternoses'] = array(self::HAS_MANY, 'CierresInternos', 'id_usuario');
        $relations['indicadoresObservaciones']=array(self::HAS_MANY, 'IndicadoresObservaciones', 'id_usuario');
        $relations['cierresInternoses']=array(self::HAS_MANY, 'CierresInternos', 'id_usuario');
        $relations['elementosGestionResponsables']=array(self::HAS_MANY, 'ElementosGestionResponsable', 'responsable_id');
        
        return $relations;
	}
    
    
    public function pivotModels() {
        return array(
            'authItems' => 'AuthAssignment',
            'centrosCostoses' => 'UsersCentros',
            'lineasAccions' => 'LaActores',
        );
    } 
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => UserModule::t("Id"),
			'username'=>UserModule::t("username"),
			'password'=>UserModule::t("password"),
			'verifyPassword'=>UserModule::t("Retype Password"),
			'email'=>UserModule::t("E-mail"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'create_at' => UserModule::t("Registration date"),			
			'lastvisit_at' => UserModule::t("Last visit"),
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),
			'authItems' => "Perfiles",
            'centrosCostoses' => 'Centro de costo',
            'rut' => "Rut",
            'nombres' => "Nombres",
            'ape_paterno' => "Ap. Paterno",
            'ape_materno' => 'Ap. Materno',
            'cargo_id' => 'Cargo',
            'cierresInternoses' => null,
            'indicadores' => null,
            'lineasAccions' => null,
            'lineasAccions1' => null,
            'lineasAccions2' => null,
            'estado'=>'Estado',
            'centrosCostoses'=>'Centro de costo',
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            /*'banned'=>array(
                'condition'=>'status='.self::STATUS_BANNED,
            ),*/
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, create_at, lastvisit_at, superuser, status,nombres,rut,ape_paterno,ape_materno,cargo_id',
            ),
        );
    }
	
	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => 'user.id, user.username, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status,user.nombres,user.rut,user.ape_paterno,user.ape_materno,user.cargo_id',
        ));
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				//self::STATUS_BANNED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
	
/**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);
        $criteria->compare('cargo_id', $this->cargo_id);
        $criteria->compare('estado', 1);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at=date('Y-m-d H:i:s',$value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at=date('Y-m-d H:i:s',$value);
    }
    
    public function getNombrecompleto(){
        return $this->ape_paterno.' '.$this->ape_materno.' '.$this->nombres.' - '.$this->rut;   
    }
    
    public function getNombreycargo(){
        return array($this->ape_paterno.' '.$this->ape_materno.' '.$this->nombres,$this->cargo);   
    }
    
	public function getRutcompleto(){
        return $this->nombres.' '.$this->ape_paterno.' '.$this->ape_materno.' - '.$this->rut;   
    }

    public function getPerfiles(){
        $datos=false;
        $perfilString="";
        foreach($this->authItems as $perfil){
            if($datos){
                $perfilString.=",";
            }
            $datos=true;
            $perfilString.=$perfil->description;            
        }
        return $perfilString;
    }
            
    public static function responsablesPorCentroCosto($id){
    	if(!isset($id) || is_null($id)){
    	    $id=0;
    	}
    	$criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->join ='INNER JOIN users_centros uc ON id=uc.user_id INNER JOIN centros_costos cc ON cc.id = uc.centro_id 
        INNER JOIN divisiones d ON d.id = cc.division_id INNER JOIN productos_estrategicos pe ON pe.division_id = d.id
        INNER JOIN subproductos sb ON sb.producto_estrategico_id = pe.id  INNER JOIN productos_especificos pes ON pes.subproducto_id = sb.id INNER JOIN indicadores i ON i.producto_especifico_id = pes.id';
        $criteria->addCondition('i.estado = 1 AND pes.estado = 1 AND sb.estado = 1 AND pe.estado = 1 
        AND d.estado = 1 AND cc.estado = 1 AND status = 1 AND user.estado=1 AND cc.id ='.$id);

        
        $responsables = User::model()->findAll($criteria);
        
        return $responsables;
    	
    	
    }
    
    public function getActoresLA($id_la){

    	$criteria = new CDbCriteria;
    	$criteria->select = 'nombres, id';
    	$criteria->join = 'INNER JOIN la_actores la ON la.id_usuario = id';
    	$criteria->compare('la.id_la', $id_la);
        $criteria->compare('estado', 1);//Se debe agregar el estado 1 para mostrar solo los activos. 
    	$actores = User::model()->findAll($criteria);
    	
    	$actoresCadena = '';
    	$bandera =0;
    	for($i=0; $i<count($actores); $i++){
    		
    		
    		if($bandera==0){
    			$actoresCadena = $actoresCadena.''.$actores[$i]['nombres'];
    			$bandera = 1;
    		}else{
    			$actoresCadena = $actoresCadena.', '.$actores[$i]['nombres'];
    		}
    		
    		
    	}//fin for
    	
    	return $actoresCadena;
    }//fin funcion

}