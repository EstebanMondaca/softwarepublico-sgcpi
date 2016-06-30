<?php


/**
 * This is the model base class for the table "tipos_formulas".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "TiposFormulas".
 *
 * Columns in table "tipos_formulas" available as properties of the model,
 * followed by relations of table "tipos_formulas" available as properties of the model.
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $estado
 * @property string $formula
 *
 * @property Indicadores[] $indicadores
 */
abstract class BaseTiposFormulas extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tipos_formulas';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Tipo De Fórmula|Tipos De Fórmulas', $n);
	}

	public static function representingColumn() {
		return 'nombre';
	}

	public function rules() {
		return array(
			array('nombre, unidad_id', 'required'),
			array('estado,unidad_id', 'numerical', 'integerOnly'=>true),
			array('nombre, formula', 'length', 'max'=>200),
			array('estado, formula', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, nombre, estado, formula, tipo_resultado,unidad_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'indicadores' => array(self::HAS_MANY, 'Indicadores', 'tipo_formula_id'),
			'unidad' => array(self::BELONGS_TO, 'Unidades', 'unidad_id'),
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
			'formula' => Yii::t('app', 'Formula'),
			'unidad' => null,
			'unidad_id' => Yii::t('app', 'Unidad'),
			'tipo_resultado' => Yii::t('app', 'Tipo Resultado'),
			'indicadores' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('nombre', $this->nombre, true);
		$criteria->compare('estado', $this->estado);
		$criteria->compare('formula', $this->formula, true);
		$criteria->compare('unidad_id', $this->unidad_id);	
		$criteria->condition='t.estado = 1';
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
	public function columnaFormulaReporte($data, $row){
		$criteria = new CDbCriteria;
		
		$criteria->select='t.nombre, i.formula';
		$criteria->join='INNER join indicadores i ON t.id = i.tipo_formula_id';
		$criteria->condition='i.id = '.$data['id'];
		
		$formula = TiposFormulas::model()->findAll($criteria);
		$formulaCadena = '';
		
		for($j=0; $j<count($formula); $j++){
			
			if(empty($formula[$j]['nombre'])){
				$formula[$j]['nombre']=' ';
			}
			if(empty($formula[$j]['formula'])){
				$formula[$j]['formula']=' ';
			}
			
			$formulaCadena = $formulaCadena.'<u><i><b>'.$formula[$j]['nombre'].'</b></i></u><br/><br/><br/>'.$formula[$j]['formula'];
			
		}//fin for
		
		return $formulaCadena;
	}//fin funcion
	
	public function columnaFormulaReporteReport($id, $bandera){
		$criteria = new CDbCriteria;
		
		$criteria->select='t.nombre, i.formula';
		$criteria->join='INNER join indicadores i ON t.id = i.tipo_formula_id';
		$criteria->condition='i.id = '.$id;
		
		$formula = TiposFormulas::model()->findAll($criteria);
		$formulaCadena = '';
		
		if($bandera==0){
		
			for($j=0; $j<count($formula); $j++){
				
				if(empty($formula[$j]['nombre'])){
					$formula[$j]['nombre']=' ';
				}
				if(empty($formula[$j]['formula'])){
					$formula[$j]['formula']=' ';
				}
				
				$formulaCadena = $formulaCadena.'<u><i><b>'.$formula[$j]['nombre'].'</b></i></u><br/><br/><br/>'.$formula[$j]['formula'];
				
			}//fin for
		}else{
			
			for($j=0; $j<count($formula); $j++){
				
				if(empty($formula[$j]['nombre'])){
					$formula[$j]['nombre']=' ';
				}
				if(empty($formula[$j]['formula'])){
					$formula[$j]['formula']=' ';
				}
				
				$formulaCadena = $formulaCadena.$formula[$j]['nombre'].'<br/>'.$formula[$j]['formula'];
				
			}//fin for
			
		}
		
		return $formulaCadena;
	}//fin funcion
}