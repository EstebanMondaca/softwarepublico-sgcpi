<?php

$this->breadcrumbs = array(
	 'Reportes'
);
?>

<div class="fieldset2 amarilloClaro parametros left" style="height: 400px;">
    <h2>Definiciones Estratégicas</h2>
        <div class="amarilloClaro">
              <a class="etapa2 blanco left" href="<?php echo Yii::app()->request->baseUrl;?>/mapaEstrategico/reporte">Mapa Estratégico</a>
              <a class="etapa2 blanco left" href="<?php echo Yii::app()->request->baseUrl;?>/reportes/cadenaValorNegocio">Cadena de Valor<br/> del Negocio</a>
              <a class="etapa2 blanco left"href="<?php echo Yii::app()->request->baseUrl;?>/reportes/cadenaValorApoyo">Cadena de Valor<br/> de Apoyo</a>
        </div>  
</div>

<div class="fieldset2 amarillo parametros left" style="height: 400px;">
    <h2>Planes</h2>
        <div class="amarillo">
             <a  class="etapa2 blanco left" href="<?php echo Yii::app()->request->baseUrl;?>/reportes/formularioH">Formulario H</a>
             <a  class="etapa2 blanco left" href="<?php echo Yii::app()->request->baseUrl;?>/reportes/formularioA1">Formulario A1</a>
             <a  class="etapa2 blanco left" href="<?php echo Yii::app()->request->baseUrl;?>/reporteConvenioDesempenoColecitvo">Convenio Desempeño Colectivo</a>
        </div>  
</div>

<div class="fieldset2 verde parametros left" style="height: 400px;">
    <h2>Seguimiento y Resultados</h2>
        <div class="verde">
               <a  class="etapa2 blanco left" href="<?php echo Yii::app()->request->baseUrl;?>/reporteAvanceIndicadores">Avance Indicadores</a>
               <a class="etapa2 blanco left" href="<?php echo Yii::app()->request->baseUrl;?>/reporteEvaluacionCumplimiento">Cumplimiento Convenio Desempeño Colectivo</a>
               <a class="etapa2 blanco left"href="<?php echo Yii::app()->request->baseUrl;?>/ejecucionPresupuestaria"> Presupuesto de Funcionamiento</a>
        </div>  
</div>

<div class="fieldset2 amarilloClaro parametros left" style="height: 400px;">
	<h2>Mejoras de La Gestión</h2>
		<div class="amarilloClaro" id="gore">
		        <a class="etapa2 blanco left" href="<?php echo Yii::app()->request->baseUrl;?>/resumenGeneral/">Autoevaluación</a>  
                <a class="etapa2 blanco left" href="<?php echo Yii::app()->request->baseUrl;?>/reporteAmiLineaAccion">Plan de Mejoras</a>   
                <a class="etapa2 blanco left" href="<?php echo Yii::app()->request->baseUrl;?>/seguimientoPlanMejora">Cumplimiento Plan de Mejoras</a>
		</div>	
</div>

