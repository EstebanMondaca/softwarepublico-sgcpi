<?php

/**
 * This is the model base class for the table "ejecucion_presupuestaria".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "EjecucionPresupuestaria".
 *
 * Columns in table "ejecucion_presupuestaria" available as properties of the model,
 * followed by relations of table "ejecucion_presupuestaria" available as properties of the model.
 *
 * @property integer $id
 * @property integer $id_division
 * @property integer $id_centro_costo
 * @property integer $id_planificacion
 * @property integer $id_item_presupuestario
 * @property double $monto_asignado
 * @property double $acumulado
 * @property double $saldo
 * @property double $mes1
 * @property double $mes2
 * @property double $mes3
 * @property double $mes4
 * @property double $mes5
 * @property double $mes6
 * @property double $mes7
 * @property double $mes8
 * @property double $mes9
 * @property double $mes10
 * @property double $mes11
 * @property double $mes12
 * @property integer $estado
 *
 * @property ItemesPresupuestarios $idItemPresupuestario
 * @property CentrosCostos $idCentroCosto
 * @property Divisiones $idDivision
 * @property Planificaciones $idPlanificacion
 */
abstract class BaseEjecucionPresupuestaria extends GxActiveRecord {
	public $item_nom;
	public $division;
	public $centro;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'ejecucion_presupuestaria';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Ejecución Presupuestaria|Ejecuciones Presupuestarias', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('id_division, id_centro_costo, id_planificacion, id_item_presupuestario, monto_asignado, estado', 'required'),
			array('mes12, acumulado,saldo, mes1, mes2, mes3, mes4, mes5, mes6, mes7, mes8, mes9, mes10, mes11,id_division, monto_asignado, id_centro_costo, id_planificacion, id_item_presupuestario, estado', 'numerical', 'integerOnly'=>true),
			array('acumulado, saldo, mes1, mes2, mes3, mes4, mes5, mes6, mes7, mes8, mes9, mes10, mes11, mes12', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, id_division, id_centro_costo, id_planificacion, id_item_presupuestario, monto_asignado, acumulado, saldo, mes1, mes2, mes3, mes4, mes5, mes6, mes7, mes8, mes9, mes10, mes11, mes12, estado', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'idItemPresupuestario' => array(self::BELONGS_TO, 'ItemesPresupuestarios', 'id_item_presupuestario'),
			'idCentroCosto' => array(self::BELONGS_TO, 'CentrosCostos', 'id_centro_costo'),
			'idDivision' => array(self::BELONGS_TO, 'Divisiones', 'id_division'),
			'idPlanificacion' => array(self::BELONGS_TO, 'Planificaciones', 'id_planificacion'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'id_division' => null,
			'id_centro_costo' => null,
			'id_planificacion' => null,
			'id_item_presupuestario' => null,
			'monto_asignado' => Yii::t('app', 'Monto Asignado'),
			'acumulado' => Yii::t('app', 'Acumulado'),
			'saldo' => Yii::t('app', 'Saldo'),
			'mes1' => Yii::t('app', 'Mes1'),
			'mes2' => Yii::t('app', 'Mes2'),
			'mes3' => Yii::t('app', 'Mes3'),
			'mes4' => Yii::t('app', 'Mes4'),
			'mes5' => Yii::t('app', 'Mes5'),
			'mes6' => Yii::t('app', 'Mes6'),
			'mes7' => Yii::t('app', 'Mes7'),
			'mes8' => Yii::t('app', 'Mes8'),
			'mes9' => Yii::t('app', 'Mes9'),
			'mes10' => Yii::t('app', 'Mes10'),
			'mes11' => Yii::t('app', 'Mes11'),
			'mes12' => Yii::t('app', 'Mes12'),
			'estado' => Yii::t('app', 'Estado'),
			'idItemPresupuestario' => null,
			'idCentroCosto' => null,
			'idDivision' => null,
			'idPlanificacion' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('id_division', $this->id_division);
		$criteria->compare('id_centro_costo', $this->id_centro_costo);
		$criteria->compare('id_planificacion', $this->id_planificacion);
		$criteria->compare('id_item_presupuestario', $this->id_item_presupuestario);
		$criteria->compare('monto_asignado', $this->monto_asignado);
		$criteria->compare('acumulado', $this->acumulado);
		$criteria->compare('saldo', $this->saldo);
		$criteria->compare('mes1', $this->mes1);
		$criteria->compare('mes2', $this->mes2);
		$criteria->compare('mes3', $this->mes3);
		$criteria->compare('mes4', $this->mes4);
		$criteria->compare('mes5', $this->mes5);
		$criteria->compare('mes6', $this->mes6);
		$criteria->compare('mes7', $this->mes7);
		$criteria->compare('mes8', $this->mes8);
		$criteria->compare('mes9', $this->mes9);
		$criteria->compare('mes10', $this->mes10);
		$criteria->compare('mes11', $this->mes11);
		$criteria->compare('mes12', $this->mes12);
		$criteria->compare('estado', $this->estado);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
	

	public  function busquedaPersonalizada($id_division, $id_centro_costo){
		
		$id_planificacion = Yii::app()->session['idPlanificaciones'];
		$sql='select i.id AS id_item ,i.nombre AS item_nom ,e.monto_asignado,e.id,e.mes1,e.mes2,e.mes3,
		e.mes4,e.mes5,e.mes6,e.mes7,e.mes8,e.mes9,e.mes10,e.mes11,e.mes12,e.acumulado,e.saldo,e.id_division,
		e.id_centro_costo from ejecucion_presupuestaria e left join itemes_presupuestarios i on
		 (i.id = e.id_item_presupuestario) where e.id_division = '.$id_division.' and
		  e.id_centro_costo = '.$id_centro_costo.' and e.id_planificacion = '.$id_planificacion.' union 
		  select id ,nombre ,0 as monto_asignado ,null,0 as mes1 ,0 as mes2 ,0 as mes3 ,0 as mes4 ,0 as mes5 
		  ,0 as mes6 ,0 as mes7 ,0 as mes8 ,0 as mes9 ,0 as mes10 ,0 as mes11 ,0 as mes12 ,0 as acumulado,0 
		  as saldo ,'.$id_division.' as id_division ,'.$id_centro_costo.' as id_centro_costo from 
		  itemes_presupuestarios where id not in (select id_item_presupuestario from ejecucion_presupuestaria 
		  where id_division = '.$id_division.' and id_centro_costo = '.$id_centro_costo.' and id_planificacion = '.$id_planificacion.')';
		
        
		$resultado=Yii::app()->db->createCommand(''.$sql)->queryAll();;
	
		$count = count($resultado);
	
		$dataProvider=new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,

		    'pagination'=>array(
		        'pageSize'=>15,
		    ),
		));


      return $dataProvider;
		
	}


}
?>
