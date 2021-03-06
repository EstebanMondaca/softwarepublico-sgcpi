<?php

/**
 * This is the model base class for the table "planificaciones".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Planificaciones".
 *
 * Columns in table "planificaciones" available as properties of the model,
 * followed by relations of table "planificaciones" available as properties of the model.
 *
 * @property integer $id
 * @property integer $estado_planificacion_id
 * @property integer $periodo_proceso_id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $estado
 *
 * @property DesafiosEstrategicos[] $desafiosEstrategicoses
 * @property ElementosGestionPriorizados[] $elementosGestionPriorizadoses
 * @property MisionesVisiones[] $misionesVisiones
 * @property PeriodosProcesos $periodoProceso
 * @property EstadosPlanificaciones $estadoPlanificacion
 */
abstract class BasePlanificaciones extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'planificaciones';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Planificaciones|Planificaciones', $n);
	}

	public static function representingColumn() {
		return 'nombre';
	}

	public function rules() {
		return array(
			array('nombre, descripcion', 'required'),
			array('estado_planificacion_id, periodo_proceso_id, estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>200),
			array('estado_planificacion_id, periodo_proceso_id, estado', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, estado_planificacion_id, periodo_proceso_id, nombre, descripcion, estado', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(			
            'cierresInternoses' => array(self::HAS_MANY, 'CierresInternos', 'id_planificacion'),
            'desafiosEstrategicoses' => array(self::HAS_MANY, 'DesafiosEstrategicos', 'planificacion_id'),
            'ejecucionPresupuestarias' => array(self::HAS_MANY, 'EjecucionPresupuestaria', 'id_planificacion'),
            'elementosGestionPriorizadoses' => array(self::HAS_MANY, 'ElementosGestionPriorizados', 'id_planificacion'),
            'laElemGestions' => array(self::HAS_MANY, 'LaElemGestion', 'id_planificacion'),
            'misionesVisiones' => array(self::HAS_MANY, 'MisionesVisiones', 'planificacion_id'),
            'periodoProceso' => array(self::BELONGS_TO, 'PeriodosProcesos', 'periodo_proceso_id'),
            'estadoPlanificacion' => array(self::BELONGS_TO, 'EstadosPlanificaciones', 'estado_planificacion_id'),
            'productosItemes' => array(self::HAS_MANY, 'ProductosItemes', 'planificacion_id'),
            'elementosGestionResponsables' => array(self::HAS_MANY, 'ElementosGestionResponsable', 'planificacion_id'),
            'evaluacionJornadas' => array(self::HAS_MANY, 'EvaluacionJornada', 'planificacion_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'estado_planificacion_id' => null,
			'periodo_proceso_id' => null,
			'nombre' => Yii::t('app', 'Nombre'),
			'descripcion' => Yii::t('app', 'Descripcion'),
			'estado' => Yii::t('app', 'Estado'),
			'cierresInternoses' => null,
            'desafiosEstrategicoses' => null,
            'ejecucionPresupuestarias' => null,
            'elementosGestionPriorizadoses' => null,
            'laElemGestions' => null,
            'misionesVisiones' => null,
            'periodoProceso' => null,
            'estadoPlanificacion' => null,
            'elementosGestionResponsables' => null,
            'evaluacionJornadas' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('estado_planificacion_id', $this->estado_planificacion_id);
		$criteria->compare('periodo_proceso_id', $this->periodo_proceso_id);
		$criteria->compare('nombre', $this->nombre, true);
		$criteria->compare('descripcion', $this->descripcion, true);
		$criteria->compare('estado', $this->estado);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}