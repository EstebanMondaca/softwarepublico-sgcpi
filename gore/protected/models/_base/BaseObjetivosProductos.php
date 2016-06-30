<?php

/**
 * This is the model base class for the table "objetivos_productos".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ObjetivosProductos".
 *
 * Columns in table "objetivos_productos" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $objetivo_estrategico_id
 * @property integer $producto_estrategico_id
 *
 */
abstract class BaseObjetivosProductos extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'objetivos_productos';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Objetivos Productos|Objetivos Productoses', $n);
	}

	public static function representingColumn() {
		return array(
			'objetivo_estrategico_id',
			'producto_estrategico_id',
		);
	}

	public function rules() {
		return array(
			array('objetivo_estrategico_id, producto_estrategico_id', 'required'),
			array('objetivo_estrategico_id, producto_estrategico_id', 'numerical', 'integerOnly'=>true),
			array('objetivo_estrategico_id, producto_estrategico_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'objetivo_estrategico_id' => null,
			'producto_estrategico_id' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('objetivo_estrategico_id', $this->objetivo_estrategico_id);
		$criteria->compare('producto_estrategico_id', $this->producto_estrategico_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
	public function buscarobjetivosProducto($idobjetivoestrategico){
		$criteria = new CDbCriteria;
	
		$criteria->compare('objetivo_estrategico_id', $this->objetivo_estrategico_id);
		$criteria->compare('producto_estrategico_id', $this->producto_estrategico_id);
		$criteria->condition='objetivo_estrategico_id='.$idobjetivoestrategico;
		$objetivosproductos = ObjetivosProductos::model()->findAll($criteria);
	
		return $objetivosproductos;
	}
}
