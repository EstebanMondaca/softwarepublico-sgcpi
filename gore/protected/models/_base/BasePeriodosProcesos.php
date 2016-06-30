<?php

/**
 * This is the model base class for the table "periodos_procesos".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "PeriodosProcesos".
 *
 * Columns in table "periodos_procesos" available as properties of the model,
 * followed by relations of table "periodos_procesos" available as properties of the model.
 *
 * @property integer $id
 * @property string $descripcion
 *
 * @property Planificaciones[] $planificaciones
 */
abstract class BasePeriodosProcesos extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'periodos_procesos';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Periodos Procesos|Periodos Procesoses', $n);
	}

	public static function representingColumn() {
		return 'descripcion';
	}

	public function rules() {
		return array(
			array('descripcion', 'required'),
			array('descripcion', 'length', 'max'=>4),
			array('id, descripcion', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'planificaciones' => array(self::HAS_MANY, 'Planificaciones', 'periodo_proceso_id'),
			'activacionProcesos' => array(self::HAS_MANY, 'ActivacionProceso', 'periodo_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'descripcion' => Yii::t('app', 'Año'),
			'planificaciones' => null,
			'activacionProcesos' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('descripcion', $this->descripcion, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}