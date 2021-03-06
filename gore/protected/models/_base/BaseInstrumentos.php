<?php

/**
 * This is the model base class for the table "instrumentos".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Instrumentos".
 *
 * Columns in table "instrumentos" available as properties of the model,
 * followed by relations of table "instrumentos" available as properties of the model.
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $estado
 *
 * @property IndicadoresInstrumentos[] $indicadoresInstrumentoses
 */
abstract class BaseInstrumentos extends GxActiveRecord {
	public $ponderacion, $id_instrumento, $plazo_maximo, $id_indicador, $ascendente, $nom_indicador;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'instrumentos';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Instrumentos|Instrumentos', $n);
	}

	public static function representingColumn() {
		return 'nombre';
	}

	public function rules() {
		return array(
			array('nombre, estado', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>500),
			array('id, nombre, estado', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'indicadoresInstrumentoses' => array(self::HAS_MANY, 'IndicadoresInstrumentos', 'id_instrumento'),
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
			'indicadoresInstrumentoses' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('nombre', $this->nombre, true);
		$criteria->compare('estado', $this->estado);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
	
	public function indicadoresPorInstrumentos($id_instrumento){
		
        $sql='SELECT t.nombre AS instrumentoNombre, t.id AS id_instrumento, 
        fc.nombre AS frecuenciaControl,
        i.ascendente AS ascendente, i.responsable_id, pre.id AS id_pro_estrategico,
        pre.nombre AS producto_estrategico_n,
        ii.id_indicador AS id, i.nombre AS nombre, i.meta_anual AS meta_anual,
        i.meta_parcial AS meta_parcial, fc.plazo_maximo AS plazo_maximo,
        sb.nombre AS subp_nombre, pe.nombre AS pro_especifico_nom
        FROM instrumentos t
        INNER JOIN indicadores_instrumentos ii ON t.id = ii.id_instrumento
        INNER JOIN indicadores i ON ii.id_indicador = i.id
        INNER JOIN productos_especificos pe ON pe.id = i.producto_especifico_id
        INNER JOIN subproductos sb ON pe.subproducto_id = sb.id 
        INNER JOIN productos_estrategicos pre ON pre.id = sb.producto_estrategico_id
        INNER JOIN frecuencias_controles fc ON i.frecuencia_control_id = fc.id
        INNER JOIN objetivos_productos op ON pre.id = op.producto_estrategico_id
        INNER JOIN objetivos_estrategicos oe ON op.objetivo_estrategico_id = oe.id
        INNER JOIN desafios_objetivos do2 ON  oe.id = do2.objetivo_estrategico_id
        INNER JOIN desafios_estrategicos de ON do2.desafio_estrategico_id = de.id
        INNER JOIN planificaciones pl ON de.planificacion_id = pl.id
        INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id
        WHERE t.estado = 1 AND pe.estado= 1 AND sb.estado = 1 AND pre.estado = 1 AND 
        ii.estado = 1 AND i.estado = 1';
        
		if(isset(Yii::app()->session['idPeriodo'])){
			$sql =  $sql.' AND pp.id = '.Yii::app()->session['idPeriodo'];
		}
		if($id_instrumento!=0){
			$sql = $sql.' AND ii.id_instrumento='.$id_instrumento;
		}
		
        $sql=$sql.' UNION
        SELECT t2.nombre AS instrumentoNombre, t2.id AS id_instrumento,
        fc2.nombre AS frecuenciaControl, i2.ascendente AS ascendente, i2.responsable_id,
       	pre2.id AS id_pro_estrategico, pre2.nombre AS producto_estrategico_n,
       	ii2.id_indicador AS id, i2.nombre AS nombre, i2.meta_anual AS meta_anual,
       	i2.meta_parcial AS meta_parcial, fc2.plazo_maximo AS plazo_maximo,
       	la.nombre AS subp_nombre, la.nombre AS pro_especifico_nom
        FROM instrumentos t2
        INNER JOIN indicadores_instrumentos ii2 ON t2.id = ii2.id_instrumento
        INNER JOIN indicadores i2 ON ii2.id_indicador = i2.id 
        INNER JOIN lineas_accion la ON i2.id = la.id_indicador
        INNER JOIN productos_estrategicos pre2 ON la.producto_estrategico_id = pre2.id
        INNER JOIN frecuencias_controles fc2 ON i2.frecuencia_control_id = fc2.id
        INNER JOIN objetivos_productos op2 ON pre2.id = op2.producto_estrategico_id
        INNER JOIN objetivos_estrategicos oe2 ON op2.objetivo_estrategico_id = oe2.id
        INNER JOIN desafios_objetivos do3 ON  oe2.id = do3.objetivo_estrategico_id
        INNER JOIN desafios_estrategicos de2 ON do3.desafio_estrategico_id = de2.id
        INNER JOIN planificaciones pl2 ON de2.planificacion_id = pl2.id
        INNER JOIN periodos_procesos pp2 ON pl2.periodo_proceso_id = pp2.id
        WHERE t2.estado = 1 AND pre2.estado = 1 AND i2.estado = 1 AND ii2.estado = 1';
        
		if(isset(Yii::app()->session['idPeriodo'])){
			$sql =  $sql.' AND pp2.id = '.Yii::app()->session['idPeriodo'];
		}
		if($id_instrumento!=0){
			$sql = $sql.' AND ii2.id_instrumento='.$id_instrumento;
		}
        $sql = $sql.' ORDER BY id_instrumento';
        $resultado=Yii::app()->db->createCommand($sql)->queryAll();
		return $resultado;
	}
	
	public function obtenerPonderacionPorColumna($data, $row){
    	
    	$resultado = '';
    	$criteria = new CDbCriteria;
        $criteria->select = 'ii.ponderacion';
        $criteria->join ='INNER JOIN indicadores_instrumentos ii  ON t.id = ii.id_instrumento';
        $criteria->condition='ii.id_instrumento = 2 AND ii.id_indicador='.$data->id_indicador;
        $ponderaciones = Instrumentos::model()->findAll($criteria);
        
        if(!empty($ponderaciones)){
        	
        
        
        for($i=0; $i <count($ponderaciones); $i++){
        	
        	if($ponderaciones[$i]['ponderacion']==null){
        		$ponderaciones[$i]['ponderacion'] = 0;
        	}
        	if($i== (count($ponderaciones)-1)){
        		$resultado = $resultado.$ponderaciones[$i]['ponderacion'];
        	}else{
        		$resultado = $resultado.$ponderaciones[$i]['ponderacion'].',';
        	}
        }
        }else{
        	$resultado = 0;
        }
        
        return $resultado;
    }
}