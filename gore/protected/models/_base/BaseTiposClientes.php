<?php

/**
 * This is the model base class for the table "tipos_clientes".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "TiposClientes".
 *
 * Columns in table "tipos_clientes" available as properties of the model,
 * followed by relations of table "tipos_clientes" available as properties of the model.
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $estado
 *
 * @property Clientes[] $clientes
 */
abstract class BaseTiposClientes extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tipos_clientes';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Tipo Cliente|Tipos De Clientes', $n);
	}

	public static function representingColumn() {
		return 'nombre';
	}

	public function rules() {
		return array(
			array('nombre', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>200),
			array('estado', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, nombre, estado', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'clientes' => array(self::HAS_MANY, 'Clientes', 'tipo_cliente_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'nombre' => Yii::t('app', 'Nombre'),
			'estado' => Yii::t('app', 'Estado'),
			'clientes' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('nombre', $this->nombre, true);
		$criteria->compare('estado', $this->estado);
		$criteria->condition='t.estado = 1';

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}