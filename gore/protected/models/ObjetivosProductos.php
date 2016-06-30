<?php

/**
 * This is the model class for table "objetivos_productos".
 *
 * The followings are the available columns in table 'objetivos_productos':
 * @property integer $objetivo_estrategico_id
 * @property integer $producto_estrategico_id
 */
class ObjetivosProductos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObjetivosProductos the static model class
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
		return 'objetivos_productos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('objetivo_estrategico_id, producto_estrategico_id', 'required'),
			array('objetivo_estrategico_id, producto_estrategico_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('objetivo_estrategico_id, producto_estrategico_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'objetivo_estrategico_id' => 'Objetivo Estrategico',
			'producto_estrategico_id' => 'Producto Estrategico',
		);
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

		$criteria->compare('objetivo_estrategico_id',$this->objetivo_estrategico_id);
		$criteria->compare('producto_estrategico_id',$this->producto_estrategico_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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