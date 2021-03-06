<?php

/**
 * This is the model base class for the table "indicadores_observaciones".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "IndicadoresObservaciones".
 *
 * Columns in table "indicadores_observaciones" available as properties of the model,
 * followed by relations of table "indicadores_observaciones" available as properties of the model.
 *
 * @property integer $id
 * @property integer $id_indicador
 * @property integer $id_usuario
 * @property string $observacion
 * @property integer $estado
 *
 * @property Users $idUsuario
 * @property Indicadores $idIndicador
 */
abstract class BaseIndicadoresObservaciones extends GxActiveRecord {
	
	private $_nombreIndicador=null;
	private $_nombreUsuario=null;
 	public function getNombreIndicador()
	{
	    if ($this->_nombreIndicador === null && $this->idIndicador !== null)
	    {
	        $this->_nombreIndicador = $this->idIndicador->nombre;
	    }
	    return $this->_nombreIndicador;
	}
	public function setNombreIndicador($value)
	{
	    $this->_nombreIndicador = $value;
	}
 	public function getNombreUsuario()
	{
	    if ($this->_nombreUsuario === null && $this->idUsuario !== null)
	    {
	        $this->_nombreUsuario = $this->idUsuario->nombres;
	    }
	    return $this->_nombreUsuario;
	}
	public function setNombreUsuario($value)
	{
	    $this->_nombreUsuario = $value;
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'indicadores_observaciones';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Indicadores Observaciones|Indicadores Observaciones', $n);
	}

	public static function representingColumn() {
		return 'observacion';
	}

	public function rules() {
		return array(
			array('id_indicador, id_usuario, observacion, estado, fecha',  'required'),
			array('id_indicador, id_usuario, estado, tipo_observacion', 'numerical', 'integerOnly'=>true),
			array('tipo_observacion', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, id_indicador, nombreIndicador,fecha, nombreUsuario,  id_usuario, observacion, tipo_observacion, estado', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'idUsuario' => array(self::BELONGS_TO, 'User', 'id_usuario'),
			'idIndicador' => array(self::BELONGS_TO, 'Indicadores', 'id_indicador'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'id_indicador' => null,
			'id_usuario' => 'usuario',
			'observacion' => Yii::t('app', 'Observacion'),
			'estado' => Yii::t('app', 'Estado'),
			'idUsuario' => null,
			'idIndicador' => null,
			'tipo_observacion' => Yii::t('app', 'Tipo Observacion'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		//$criteria->with ='idIndicador';
		$criteria->compare('fecha', $this->fecha);
		$criteria->compare('id', $this->id);
		$criteria->compare('id_indicador', $this->id_indicador);
		$criteria->compare('id_usuario', $this->id_usuario);
		$criteria->compare('observacion', $this->observacion, true);
		$criteria->compare('estado', $this->estado);
        $criteria->compare('tipo_observacion', $this->tipo_observacion);
        
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			 'pagination'=>array(
        'pageSize'=>7,
		'params' => array(
         'paging' => '0',
   )
    ),
		));
	}
	
	public function buscaObs($id){
		$criteria = new CDbCriteria;
		$criteria->compare('id', $id);

		$obs = IndicadoresObservaciones::model()->findAll($criteria);
		return $obs;
		
	}
}