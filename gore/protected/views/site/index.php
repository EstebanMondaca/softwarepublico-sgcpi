<?php 
Yii::app()->clientScript->registerScript('ready', "
    paramPeriodo();
");

//Preguntamos si el usuario está logueado
if (Yii::app()->user->id == '0'){
		Yii::app()->request->redirect(Yii::app()->getHomeUrl());
		
}
 /* @var $this SiteController */

	$this->pageTitle=Yii::app()->name;

	 Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/gore.js');
	
	
	unset(Yii::app()->session['idPeriodoSelecionado']); //Para eliminar una varibale de sesion
	
	//Yii::app()->session['idPeriodoSelecionado'] = '2014';

  /* $this->breadcrumbs=array(
    	Yii::app()->session['idPeriodoSelecionado'],
	);*/
	
?>

<!-- <h1>Bienvenido a <i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h1> -->
<div id="estados" class="right" >
	<div id="finalizado"class="right"><img src="<?php echo Yii::app()->request->baseUrl;?>/images/ic-finalizado.png"/>Finalizado </div> 
	<div id="enproceso"class="right"><img src="<?php echo Yii::app()->request->baseUrl;?>/images/ic-proceso.png"/>En proceso </div> 
	<div id="noiniciado"class="right"><img src="<?php echo Yii::app()->request->baseUrl;?>/images/ic-noiniciado.png"/>No iniciado</div>
</div>

	<?php 
 		//echo  Yii::app()->session['idPeriodoSelecionado'];
	 	//Yii::app()->session['idPlanificaciones']=0;
		//COMENTAR 
		if(isset($_GET['periodo'])){
	 		//echo $_GET['periodo'];
		}
		
	 	echo "<h2>Seleccione el periodo  ";
	
		//echo Yii::app()->controller->module->periodosProcesos;
		
	
		$periodosEncontrados =  (GxHtml::encodeEx(GxHtml::listDataEx(PeriodosProcesos::model()->findAllAttributes(null, true))));
		
		//Yii::app()->session['idPeriodoSelecionado'] = $periodosEncontrados;
		//Año actual
		$anio=date('Y');        
		//recorrer con un form generando el select el cual tiene que ser onchage
		echo"<select id='selectPeriodo' class='selectorPeriodo' onchange='cambiarPeriodo();return false'>";
		//echo "<option value=''>Seleccione un periodo</option>";
		foreach ($periodosEncontrados as $key => $value)
		{
		    $selected='';            
		    if(isset($_GET['periodo'])){
		    	if($_GET['periodo']==$value)
		        //if($_GET['periodo']==$value || $anio==$value)
                      $selected='selected="selected"'; 
		    }else{
		        if($anio==$value)
                      $selected='selected="selected"'; 
		    }
            	
			echo "<option value=".$key." ".$selected.">".$value."</option>";
		}
	  	echo"</select> </h2>";
	    
		
	
		 //$form->DropDownList(null,'estado',GxHtml::listDataEx(PeriodosProcesos::model()->findAllAttributes(null, true)));
	?>	
	  	<div id="loadingProcesos" style="width: 140px; height: 40px;display:none;" class="precarga"></div>
	  	<div id="contenidoProcesosPrincipal" style='display:none;' class='menusProcesos'>
		  	<a href="#" onclick="activarProceso2('etapasPlanificacion'); return false;" rel="activarProceso2('etapasPlanificacion'); return false;" id="procesoPlanificacionInstitucional" class="etapaPrincipal left"><span class="texto">PROCESO DE PLANIFICACIÓN<br /> INSTITUCIONAL</span></a>
		  		<div class="flechaPrincipal left"></div>
			<a href="#"  onclick="activarProceso2('etapasControl'); return false;" rel="activarProceso2('etapasControl'); return false;" id="procesoControlGestion" class="etapaPrincipal left" ><span class="texto">PROCESO DE CONTROL <br /> DE GESTIÓN</span></a>
				<div class="flechaPrincipal left"></div>
			<a href="#" onclick="activarProceso2('etapasEvaluacion'); return false;" rel="activarProceso2('etapasEvaluacion'); return false;" id="evaluacionGestion" class="etapaPrincipal left"><span class="texto">EVALUACIÓN <br />DE LA GESTIÓN</span></a>
		       <div class="limpia"></div>
		</div>
		<div class="limpia"></div>
		<div id="contenidoProcesosSecundarios" style='display:none;' class='menusProcesos'>
		    <div id="etapasPlanificacion" class="menusSecundarios">
		        <div class="verticalRule" style="left: 100px;"></div>
		        <span class="tituloEtapa">Etapas del proceso de planificación</span>
		        <div class="limpia"></div>
    		    <a href="#" onclick="activarProceso3('etapasPlanificacionFormulacion'); return false;" rel="activarProceso3('etapasPlanificacionFormulacion'); return false;" id="formulacionEstrategica" class="etapa2 left"><span class="texto">Formulación Definiciones<br/> Estrátegicas</span></a>
                    <div class="flechaPrincipal left"></div>
                <a href="#" onclick="activarProceso3('etapasPlanificacionFormulacionIndicadores');return false;" rel="activarProceso3('etapasPlanificacionFormulacionIndicadores');return false;" id="formulacionIndicadores" class="etapa2 left" ><span class="texto">Formulación de<br/> Indicadores & Metas de<br/> Gestión</span></a>
                    <div class="flechaPrincipal left"></div>
                <a href="#" onclick="activarProceso3('etapasPlanificacionOperativa'); return false;" rel="activarProceso3('etapasPlanificacionOperativa'); return false;" id="planificacionOperativa" class="etapa2 left"><span class="texto">Planificación Operativa y<br/> Formulación<br/> Presupuestaria</span></a>
                    <div class="flechaPrincipal left"></div>
                <a href="#" onclick="activarProceso3('etapasPlanificacionAjusteFinal'); return false;" rel="activarProceso3('etapasPlanificacionAjusteFinal'); return false;" id="planificacionAjusteFinal" class="etapa2 left"><span class="texto">Ajuste Final Plan</span></a>
		         <div class="limpia"></div>
		    </div>
		   <!-- ######################################################## 
           		# EVALUACION DE GESTION
           		########################################################  -->
		     <div id="etapasEvaluacion" class="menusSecundarios">
		        <div class="verticalRule" style="left: 748px;"></div>
                <span class="tituloEtapa">Componentes de Evaluación de la gestión</span>
                <div class="limpia"></div>
                <a href="<?php echo Yii::app()->request->baseUrl;?>/evaluacionJornada/" id="evaluacion_1" class="etapa2 amarillo left" style="margin-left:60px; margin-right:60px;"><span class="texto">Evaluación de la <br/>Gestión Anual</span></a>
                
                <a href="<?php echo Yii::app()->request->baseUrl;?>/evaluacionElementosGestion/" id="evaluacion_2" class="etapa2 amarillo left" style="margin-left:60px; margin-right:60px;"><span class="texto">Autoevaluación <br/> GORE</span></a>
                
                
				<?php $id_etapa = Etapas::model()->findAll(array('condition'=>'nombre="Evaluacion de la gestion" AND estado = 1')); ?>
                	
                 <a class="etapa2 amarillo left modalIndice" href="cierresInternos/cierreInterno/<?php echo $id_etapa[0];?>"  style="margin-left:60px; margin-right:60px;" id="evaluacion_3"  ><span class="texto">Cierre Interno del <br/>Proceso</span></a>
          
                 <div class="limpia"></div>
            </div>
            <!-- ######################################################## 
           		# PROCESO DE CONTROL DE GESTION
           		########################################################  -->
            <div id="etapasControl" class="menusSecundarios">
                <div class="verticalRule" style="left: 428px;"></div>
                <span class="tituloEtapa">Componentes de Control de Gestión</span>
                <div class="limpia"></div>
                <div class="panelesControl" style="margin-top: 72px;margin-right: 24px;">
                    <span class="tituloEtapa">Panel General de Avance</span>

                    <a href="<?php echo Yii::app()->request->baseUrl;?>/panelAvances/"  id="control_1" class="etapa2 amarillo left"><span class="texto">Reporte General<br/> de Avance</span></a>
                </div>
                <div class="flechaPrincipal left" style="margin-top: 124px;margin-right: 70px;"></div>
                <div class="panelesControl" style="margin-right: 15px;">
                    <span class="tituloEtapa">Control de Avance</span>
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/panelAvances/admin"  id="control2_1" class="etapa2 amarillo left"><span class="texto">Registro de Avance<br/> Indicadores</span></a>
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/controlElementosGestion/" id="control2_2" class="etapa2 amarillo left"><span class="texto">Autoevaluación - <br/> Registro de Evidencia</span></a>
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/ejecucionPresupuestaria/"  id="control2_3" class="etapa2 amarillo left"><span class="texto">Avance Presupuesto<br/>  por CR / CC</span></a>
                </div>
                <div class="flechaPrincipal left" style="margin-top: 124px;margin-right: 51px;"></div>
                     
					<?php $id_etapa = Etapas::model()->findAll(array('condition'=>'nombre="Proceso de control" AND estado = 1')); ?>
                	
                    <a class="etapa2 amarillo left modalIndice" href="cierresInternos/cierreInterno/<?php echo $id_etapa[0];?>" style="margin-top: 112px;" id="control_3" ><span class="texto">Cierre del Año</span></a>
                    
                	<!-- <a class="etapa2 amarillo left" href="#"  onclick="return false;" id="control_3" ><span class="texto">Cierre del Año</span></a>      -->         
                 <div class="limpia"></div>
            </div>
            <div class="limpia"></div>
		</div>
		   <!-- ######################################################## 
           		# FORMULACION DE DEFINICIONES ESTRATEGICAS
           		########################################################  -->
		<div id="contenidoProcesosTercero" style='display:none;' class='menusProcesos'>
		    <div id="etapasPlanificacionFormulacion" class="menusTerceros">
		        <div class="verticalRule" style="left: 70px;"></div>
		        <div class="contenedores1">
		            <a href="<?php echo Yii::app()->request->baseUrl;?>/desafiosEstrategicos/" id="formulacionEstrategica_1_1" class="etapa3 left amarillo"><span class="texto">Definición de Desafíos<br/> Estratégicos</span></a>
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/MisionesVisiones/" id="formulacionEstrategica_1_2" class="etapa3 left amarillo"><span class="texto">Definición de Misión</span></a>
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/objetivosEstrategicos/" id="formulacionEstrategica_1_3" class="etapa3 left amarillo"><span class="texto">Definición de Objetivos<br/> Estratégicos</span></a>               
		              <div class="limpia"></div>
		        </div>		        
		        <div class="flechaPrincipal left" style="margin-top: 83px;"></div>
		        <div class="contenedores1">
		            <a href="<?php echo Yii::app()->request->baseUrl;?>/productosEstrategicos/1/" id="formulacionEstrategica_2_1" class="etapa3 left amarillo"><span class="texto">Productos Estratégicos<br/> del Negocio</span></a>
		            <a href="<?php echo Yii::app()->request->baseUrl;?>/productosEstrategicos/2/" id="formulacionEstrategica_2_2" class="etapa3 left amarillo"><span class="texto">Productos Estratégicos<br/> de Apoyo</span></a>
		            <a href="<?php echo Yii::app()->request->baseUrl;?>/elementosGestionPriorizados/" id="formulacionEstrategica_2_3" class="etapa3 left amarillo"><span class="texto">Elementos de Gestión</span></a>
                    <div class="limpia"></div>
                </div>
                <div class="flechaPrincipal left" style="margin-top: 83px;"></div>
                <div class="contenedores1" style="margin-top: 68px;">
                	<?php $id_etapa = Etapas::model()->findAll(array('condition'=>'nombre="Definiciones Estratégicas" AND estado = 1')); 
                	?>
                    <a class="etapa3 left amarillo modalIndice" href="cierresInternos/cierreInterno/<?php echo $id_etapa[0];?>  " id="formulacionEstrategica_3" >Cierre Interno<br/> de la Etapa</a>                    
                   

                    <div class="limpia"></div>
                </div>
                <div class="limpia"></div>
           </div>
           <!-- ######################################################## 
           		# FORMULACION DE INDICADORES Y METAS DE LA GESTION 
           		########################################################  -->
            <div id="etapasPlanificacionFormulacionIndicadores" class="menusTerceros">
                <div class="verticalRule" style="left: 314px;"></div>
                <div class="contenedores1">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/indicadores" id="indicadoresymetas_1_1" class="etapa3 left"><span class="texto">Definir Indicadores <br/>y Metas</span></a>
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/lineasAccion/" id="indicadoresymetas_1_2" class="etapa3 left"><span class="texto">Definición de <br/>Líneas de Acción y AMI</span></a>             

                      <div class="limpia"></div>
                </div>              
                <div class="flechaPrincipal left" style="margin-top: 30px;"></div>
                <div class="contenedores1" style="margin-top: 24px;">

                    <a href="<?php echo Yii::app()->request->baseUrl;?>/indicadoresInstrumentos/" id="indicadoresymetas_2_1" class="etapa3 left"><span class="texto ">Asignar Indicadores</span></a>

                    <div class="limpia"></div>
                </div>
                <div class="flechaPrincipal left" style="margin-top: 30px;"></div>
                <div class="contenedores1" style="margin-top: 24px;">
                 <?php $id_etapa = Etapas::model()->findAll(array('condition'=>'nombre="Indicadores y Metas de Gestion" AND estado = 1')); ?>
                	
                    <a class="etapa3 left modalIndice" href="cierresInternos/cierreInterno/<?php echo $id_etapa[0];?>  " id="indicadoresymetas_3" >Cierre Interno<br/> de la Etapa</a>
                   
                    <div class="limpia"></div>
                </div>
                <div class="limpia"></div>
           </div>
           <!-- ######################################################## 
           		# PLANIFICACION OPERATIVA Y FORMULACION PRESUPUESTARIA
           		########################################################  -->
           <div id="etapasPlanificacionOperativa" class="menusTerceros">
               <div class="verticalRule" style="left: 530px;"></div>
                <div class="contenedores1">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/actividades/" id="planificacionoperativa_1_1" class="etapa3 etapaAlto left"><span class="texto">Planificación de <br/>Actividades y <br/>Presupuesto por <br/>Indicador</span></a>
                       
                      <div class="limpia"></div>
                </div>          
                <div class="flechaPrincipal left" style="margin-top: 30px;"></div>    
                <div class="contenedores1">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/presupuestoCentrosCostos/" id="planificacionoperativa_2_1" class="etapa3 etapaAlto left"><span class="texto">Asignación de <br/>Presupuesto por <br/>Centro de Costo <br/>Asociado a <br/>Productos Estratégicos</span></a>
                    <div class="limpia"></div>
                </div>
                <div class="flechaPrincipal left" style="margin-top: 30px;"></div>
                <div class="contenedores1" style="margin-top: 20px;">
                    
                     <?php $id_etapa = Etapas::model()->findAll(array('condition'=>'nombre="Planificacion Operativa" AND estado = 1')); 
                     
                     
                     ?>
                	
                    <a class="etapa3 left modalIndice" href="cierresInternos/cierreInterno/<?php echo $id_etapa[0];?>  " id="planificacionoperativa_3" >Cierre Interno<br/> de la Etapa</a>
                 
                    <div class="limpia"></div>
                </div>
                <div class="limpia"></div>
           </div>
           <!-- ######################################################## 
           		# AJUSTE FINAL PLAN 
           		########################################################  -->
           		
            <div id="etapasPlanificacionAjusteFinal" class="menusTerceros">
                <div class="verticalRule" style="left: 730px;"></div>
                <div class="contenedores2" style="margin-top: 0px;">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/desafiosEstrategicos/" id="planificacionajustefinal_1_1" class="etapa3 left amarillo"><span class="texto">Definición de Desafíos<br/> Estratégicos</span></a>
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/MisionesVisiones/" id="planificacionajustefinal_1_2" class="etapa3 left amarillo"><span class="texto">Definición de Misión</span></a>
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/objetivosEstrategicos/" id="planificacionajustefinal_1_3" class="etapa3 left amarillo"><span class="texto">Definición de Objetivos<br/> Estratégicos</span></a>               
                    <div class="limpia"></div>
                </div>      
     
                <div class="contenedores2">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/productosEstrategicos/1/" id="planificacionajustefinal_2_1" class="etapa3 left amarillo"><span class="texto">Productos Estratégicos<br/> del Negocio</span></a>
		            <a href="<?php echo Yii::app()->request->baseUrl;?>/productosEstrategicos/2/" id="planificacionajustefinal_2_2" class="etapa3 left amarillo"><span class="texto">Productos Estratégicos<br/> de Apoyo</span></a>
		            <a href="<?php echo Yii::app()->request->baseUrl;?>/elementosGestionPriorizados/" id="planificacionajustefinal_2_3" class="etapa3 left amarillo"><span class="texto">Áreas de Mejora <br/>de la Gestión</span></a>
		          <div class="limpia"></div>
                </div>
                   
                <div class="contenedores2">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/indicadores" id="planificacionajustefinal_3_1" class="etapa3 left  amarillo"><span class="texto">Definir Indicadores <br/>y Metas</span></a>
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/lineasAccion/" id="planificacionajustefinal_3_2" class="etapa3 left amarillo"><span class="texto">Definición de <br/>Líneas de Acción y AMI</span></a>
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/indicadoresInstrumentos/" id="planificacionajustefinal_3_3" class="etapa3 left  amarillo"><span class="texto ">Asignar Indicadores</span></a>             
                    <div class="limpia"></div>
                </div>
               
                <div class="contenedores2" style="margin-top: 0px;">
                	<a href="<?php echo Yii::app()->request->baseUrl;?>/actividades/" id="planificacionajustefinal_4_1" class="etapa3 etapaAlto left  amarillo"><span class="texto">Planificación de <br/>Actividades y <br/>Presupuesto por <br/>Indicador</span></a>
               		<a href="<?php echo Yii::app()->request->baseUrl;?>/presupuestoCentrosCostos/" id="planificacionajustefinal_4_2" class="etapa3 etapaAlto left  amarillo"><span class="texto">Asignación de <br/>Presupuesto por <br/>Centro de Costo <br/>Asociado a <br/>Productos Estratégicos</span></a>	
                    
                    <?php $id_etapa = Etapas::model()->findAll(array('condition'=>'nombre="Ajuste Final del Plan" AND estado = 1')); ?>  	
                   	<a class="etapa3 left modalIndice  amarillo" href="cierresInternos/cierreInterno/<?php echo $id_etapa[0];?>  " id="planificacionajustefinal_4_3" >Cierre Interno<br/> de la Etapa</a>
                  	<div class="limpia"></div>
                </div>
                <div class="limpia"></div>
           </div>
           <!-- Termino -- AJUSTE FINAL PLAN  -->
           
		</div>
	  	<div class="limpia"></div>
