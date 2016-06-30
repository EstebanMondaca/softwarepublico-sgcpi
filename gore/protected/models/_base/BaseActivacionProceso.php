<?php

/**
 * This is the model base class for the table "activacionProceso".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ActivacionProceso".
 *
 * Columns in table "activacionProceso" available as properties of the model,
 * followed by relations of table "activacionProceso" available as properties of the model.
 *
 * @property integer $id
 * @property integer $periodo_id
 * @property string $nombre_contenedor
 * @property string $inicio
 * @property string $fin
 *
 * @property PeriodosProcesos $periodo
 */
abstract class BaseActivacionProceso extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'activacionProceso';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Etapa de la Planificación|Etapas de la Planificación', $n);
	}

	public static function representingColumn() {
		return 'nombre_contenedor';
	}

	public function rules() {
		return array(
			array('inicio, fin', 'required'),
			array('periodo_id', 'numerical', 'integerOnly'=>true),
			array('nombre_contenedor', 'length', 'max'=>255),
			array('periodo_id, nombre_contenedor', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, periodo_id, nombre_contenedor, inicio, fin', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'periodo' => array(self::BELONGS_TO, 'PeriodosProcesos', 'periodo_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'periodo_id' => Yii::t('app', 'Periodo'),
			'nombre_contenedor' => Yii::t('app', 'Etapa'),
			'inicio' => Yii::t('app', 'Fecha de Inicio'),
			'fin' => Yii::t('app', 'Fecha de Termino'),
			'periodo' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		//$criteria->compare('periodo_id', $this->periodo_id);
		$criteria->compare('periodo_id', Yii::app()->session['idPeriodo']);
		$criteria->compare('nombre_contenedor', $this->nombre_contenedor, true);
		$criteria->compare('inicio', $this->inicio, true);
		$criteria->compare('fin', $this->fin, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}