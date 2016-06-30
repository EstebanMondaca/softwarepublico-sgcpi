<?php

/**
 * This is the model base class for the table "asociaciones".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Asociaciones".
 *
 * Columns in table "asociaciones" available as properties of the model,
 * followed by relations of table "asociaciones" available as properties of the model.
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $estado
 *
 * @property Indicadores[] $indicadores
 */
abstract class BaseAsociaciones extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'asociaciones';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Asociaciones|Asociaciones', $n);
	}

	public static function representingColumn() {
		return 'nombre';
	}

	public function rules() {
		return array(
			array('nombre, descripcion', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>200),
			array('estado', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, nombre, descripcion, estado', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'indicadores' => array(self::HAS_MANY, 'Indicadores', 'asociacion_id'),
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
			'descripcion' => Yii::t('app', 'Descripcion'),
			'estado' => Yii::t('app', 'Estado'),
			'indicadores' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('nombre', $this->nombre, true);
		$criteria->compare('descripcion', $this->descripcion, true);
		$criteria->compare('estado', $this->estado);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}