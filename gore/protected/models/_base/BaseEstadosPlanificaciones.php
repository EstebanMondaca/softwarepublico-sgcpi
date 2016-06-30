<?php

/**
 * This is the model base class for the table "estados_planificaciones".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "EstadosPlanificaciones".
 *
 * Columns in table "estados_planificaciones" available as properties of the model,
 * followed by relations of table "estados_planificaciones" available as properties of the model.
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property Planificaciones[] $planificaciones
 */
abstract class BaseEstadosPlanificaciones extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'estados_planificaciones';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Estados de las Planificaciones|Estados de las Planificaciones', $n);
	}

	public static function representingColumn() {
		return 'nombre';
	}

	public function rules() {
		return array(
			array('nombre', 'required'),
			array('nombre', 'length', 'max'=>200),
			array('id, nombre', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'planificaciones' => array(self::HAS_MANY, 'Planificaciones', 'estado_planificacion_id'),
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
			'planificaciones' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('nombre', $this->nombre, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}