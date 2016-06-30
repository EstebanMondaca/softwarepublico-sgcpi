<?php 
/* Formato Json
  {
    "procesos".$id: [
        {
            "idDiv": "procesoPlanificacionInstitucional",
            "activo": "0"
        },
        {
            "idDiv": "procesoControlGestion",
            "activo": "1"
        },
        {
            "idDiv": "n",
            "activo": "1/0"
        }
    ],
    "anio": "2012"
}
*/
//Declaramos el arreglo
  $procesos = array();
	
//echo $cierreInterno->fecha_cierre;
                 		              		
//Consultamos por el anio del proceso asociado al ID
$wherePeriodoProcesos = PeriodosProcesos::model()->find("id =".$id);
//Agregamos a la variable de sesion el periodo selecionado ej:2012
Yii::app()->session['idPeriodoSelecionado']=$wherePeriodoProcesos->descripcion;
Yii::app()->session['idPeriodo']=$wherePeriodoProcesos->id;

//Consultamos por el id de la planificacion
$wherePlanificaciones = Planificaciones::model()->find("periodo_proceso_id =".$id);
	unset(Yii::app()->session['idPlanificaciones']); //Para eliminar una varibale de sesion

	if (isset($wherePlanificaciones)){
	//Asignamos el id de la planificacion 
		Yii::app()->session['idPlanificaciones']=$wherePlanificaciones->id;
	}else{
		Yii::app()->session['idPlanificaciones']=0;
	}
	
	// 1=	amarillo (En proceso)
	// 2=   verde (Finalizado)
	// 0=   Blanco (No Iniciado)
   /*#########################################################################
	 ##					 Menu Principal
	 #########################################################################*/
	//Periodo a consultar (id)
	$whereActivacionProceso = ActivacionProceso::model()->findAll("periodo_id =".$id); 
	//Obtenemos la fecha actual
	$fechaHoy= date("Y-m-d H:i:s");
	//Asignamos la fecha Actual
	$hoy=strtotime($fechaHoy);	
	foreach ($whereActivacionProceso as $indice => $valor) {
		//Fecha Inicio del proceso
		$inicioProceso = strtotime($valor->inicio);
		//Fecha Fin del proceso
		$finProceso 	= strtotime($valor->fin);	
		
		$activo = null;			
		//La fecha de $fin tiene que ser menor a la fecha de hoy para que el proceso esté activo
		if($hoy >=$inicioProceso ){
			$activo='1';//En proceso
		}else{
			$activo='0';//No iniciado	
		}
		//Agregamos al arreglo $procesos el contenido
		array_push($procesos, array('idDiv'=>$valor->nombre_contenedor,'activo'=>$activo));	
		

		if ($valor->nombre_contenedor == 'procesoPlanificacionInstitucional'){
			Yii::app()->session['planificacion']=$activo;
		}
		
		if ($valor->nombre_contenedor == 'procesoControlGestion'){
			Yii::app()->session['control']=$activo;
		
		}
		if ($valor->nombre_contenedor == 'evaluacionGestion'){
			Yii::app()->session['evaluacion']=$activo;
		}		
		
		
		
		
	}
	
	 /*#########################################################################
	 ##				END -	 Menu Principal
	 #########################################################################*/
	
	
	/*#########################################################################
	  ##	 Cierre Interno de la etapa  "Definiciones Estratégicas"
	  #########################################################################*/
	$id_etapa1 = Etapas::model()->find(array('condition'=>'nombre="Definiciones Estratégicas" AND estado = 1'));
	$cierreInterno1=	CierresInternos::model()->find(array('condition'=>'id_etapa="'.$id_etapa1->id.'" AND id_planificacion='.Yii::app()->session['idPlanificaciones'].'  AND estado = 1')); 
    if(isset($cierreInterno1)){
    	//Agregamos al arreglo $procesos el contenido Finalizado
		array_push($procesos, array('idDiv'=>'formulacionEstrategica_3','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'formulacionEstrategica_2_3','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'formulacionEstrategica_2_2','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'formulacionEstrategica_2_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'formulacionEstrategica_1_3','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'formulacionEstrategica_1_2','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'formulacionEstrategica_1_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'formulacionEstrategica','activo'=>'2'));
		//Agregamos al arreglo $procesos el contenido En proceso
		array_push($procesos, array('idDiv'=>'indicadoresymetas_3','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'indicadoresymetas_1_1','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'indicadoresymetas_1_2','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'indicadoresymetas_2_1','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'formulacionIndicadores','activo'=>'1'));
	}else{
		//Agregamos al arreglo $procesos el contenido No iniciado
		array_push($procesos, array('idDiv'=>'formulacionIndicadores','activo'=>'0'));
		//Agregamos al arreglo $procesos el contenido En proceso
		array_push($procesos, array('idDiv'=>'formulacionEstrategica','activo'=>'1'));
	}
	 /*#########################################################################
	  ##	 END -  "Definiciones Estratégicas"
	  #########################################################################*/
	
	/*#########################################################################
	  ##	 Cierre Interno de la etapa  "Indicadores y Metas de Gestion"
	  #########################################################################*/
	$id_etapa2 = Etapas::model()->find(array('condition'=>'nombre="Indicadores y Metas de Gestion" AND estado = 1'));
	$cierreInterno2=	CierresInternos::model()->find(array('condition'=>'id_etapa="'.$id_etapa2->id.'" AND id_planificacion='.Yii::app()->session['idPlanificaciones'].'  AND estado = 1')); 
    if(isset($cierreInterno2)){
    	//Agregamos al arreglo $procesos el contenido Finalizado
		array_push($procesos, array('idDiv'=>'indicadoresymetas_3','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'indicadoresymetas_1_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'indicadoresymetas_1_2','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'indicadoresymetas_2_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'formulacionIndicadores','activo'=>'2'));
		//Agregamos al arreglo $procesos el contenido En proceso
		array_push($procesos, array('idDiv'=>'planificacionOperativa','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionoperativa_1_1','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionoperativa_2_1','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionoperativa_3','activo'=>'1'));
	}else{
		array_push($procesos, array('idDiv'=>'planificacionOperativa','activo'=>'0'));
	}
	 /*#########################################################################
	  ##	 END -  "Indicadores y Metas de Gestion"
	  #########################################################################*/
		
	
	/*#########################################################################
	  ##	 Cierre Interno de la etapa  "planificacionOperativa"
	  #########################################################################*/
	$id_etapa3 = Etapas::model()->find(array('condition'=>'nombre="Planificacion Operativa" AND estado = 1'));
	$cierreInterno3=	CierresInternos::model()->find(array('condition'=>'id_etapa="'.$id_etapa3->id.'" AND id_planificacion='.Yii::app()->session['idPlanificaciones'].'  AND estado = 1')); 
    if(isset($cierreInterno3)){
    	//Agregamos al arreglo $procesos el contenido Finalizado
		array_push($procesos, array('idDiv'=>'planificacionOperativa','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionoperativa_1_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionoperativa_2_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionoperativa_3','activo'=>'2'));
		//Agregamos al arreglo $procesos el contenido En proceso
		array_push($procesos, array('idDiv'=>'planificacionAjusteFinal','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_1_1','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_1_2','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_1_3','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_2_1','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_2_2','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_2_3','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_3_1','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_3_2','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_3_3','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_4_1','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_4_2','activo'=>'1'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_4_3','activo'=>'1'));
		
		
	}else{
		array_push($procesos, array('idDiv'=>'planificacionAjusteFinal','activo'=>'0'));
		//array_push($procesos, array('idDiv'=>'procesoControlGestion','activo'=>'0'));
	}
	 /*#########################################################################
	  ##	 END -  "Indicadores y Metas de Gestion"
	  #########################################################################*/

		/*#########################################################################
	  ##	 Cierre Interno de la etapa  "Ajuste Final del Plan"
	  #########################################################################*/
	$id_etapa4 = Etapas::model()->find(array('condition'=>'nombre="Ajuste Final del Plan" AND estado = 1'));
	$cierreInterno4=	CierresInternos::model()->find(array('condition'=>'id_etapa="'.$id_etapa4->id.'" AND id_planificacion='.Yii::app()->session['idPlanificaciones'].'  AND estado = 1')); 
    if(isset($cierreInterno4)){
    	//Agregamos al arreglo $procesos el contenido Finalizado
    	array_push($procesos, array('idDiv'=>'procesoPlanificacionInstitucional','activo'=>'2'));
    	array_push($procesos, array('idDiv'=>'planificacionAjusteFinal','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_1_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_1_2','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_1_3','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_2_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_2_2','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_2_3','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_3_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_3_2','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_3_3','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_4_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_4_2','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'planificacionajustefinal_4_3','activo'=>'2'));
		//Agregamos al arreglo $procesos el contenido En proceso 
		//array_push($procesos, array('idDiv'=>'procesoControlGestion','activo'=>'1'));
		
	}else {
		//Agregamos al arreglo $procesos el contenido No Iniciado
		//array_push($procesos, array('idDiv'=>'procesoControlGestion','activo'=>'0'));
	}
	 /*#########################################################################
	  ##	 END -  "Ajuste Final del Plan"
	  #########################################################################*/
	
	 
	 /*#########################################################################
	  ##	 Cierre del año  "Proceso de control"
	  #########################################################################*/
	$id_etapa5 = Etapas::model()->find(array('condition'=>'nombre="Proceso de control" AND estado = 1'));
	$cierreInterno5=	CierresInternos::model()->find(array('condition'=>'id_etapa="'.$id_etapa5->id.'" AND id_planificacion='.Yii::app()->session['idPlanificaciones'].'  AND estado = 1')); 
    if(isset($cierreInterno5)){
    	//Agregamos al arreglo $procesos el contenido Finalizado
    	array_push($procesos, array('idDiv'=>'procesoControlGestion','activo'=>'2'));
		
    	array_push($procesos, array('idDiv'=>'control2_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'control2_2','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'control2_3','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'control_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'control_3','activo'=>'2'));
		
		//Agregamos al arreglo $procesos el contenido En proceso 
		//array_push($procesos, array('idDiv'=>'evaluacionGestion','activo'=>'1'));
		
	}else {
		//Agregamos al arreglo $procesos el contenido No Iniciado
		//array_push($procesos, array('idDiv'=>'procesoControlGestion','activo'=>'0'));
		//array_push($procesos, array('idDiv'=>'evaluacionGestion','activo'=>'0'));
	}
	 /*#########################################################################
	  ##	 END -  "Proceso de control"
	  #########################################################################*/
	
		 /*#########################################################################
	  ##	 Cierre del año  "evaluacionGestion"
	  #########################################################################*/
	$id_etapa5 = Etapas::model()->find(array('condition'=>'nombre="Evaluacion de la gestion" AND estado = 1'));
	$cierreInterno5=	CierresInternos::model()->find(array('condition'=>'id_etapa="'.$id_etapa5->id.'" AND id_planificacion='.Yii::app()->session['idPlanificaciones'].'  AND estado = 1')); 
    if(isset($cierreInterno5)){
    	//Agregamos al arreglo $procesos el contenido Finalizado
    	array_push($procesos, array('idDiv'=>'evaluacionGestion','activo'=>'2'));
		
    	array_push($procesos, array('idDiv'=>'evaluacion_1','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'evaluacion_2','activo'=>'2'));
		array_push($procesos, array('idDiv'=>'evaluacion_3','activo'=>'2'));
		
		//Agregamos al arreglo $procesos el contenido En proceso 
		//array_push($procesos, array('idDiv'=>'evaluacionGestion','activo'=>'1'));
		
	}else {
		//Agregamos al arreglo $procesos el contenido No Iniciado
		//array_push($procesos, array('idDiv'=>'procesoControlGestion','activo'=>'0'));
		//array_push($procesos, array('idDiv'=>'evaluacionGestion','activo'=>'0'));
	}
	 /*#########################################################################
	  ##	 END -  "evaluacionGestion"
	  #########################################################################*/

				
//$value = array('procesos' => $procesos, 'anio' => $wherePeriodoProcesos['descripcion'],'idPlanificacion'=>$wherePlanificaciones->id);
$value = array('procesos' => $procesos, 'anio' => $wherePeriodoProcesos['descripcion']);

$output = CJSON::encode($value);
//CJSON::decode($array)

 
print($output);
 

?>