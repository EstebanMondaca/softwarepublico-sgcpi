<?php
Yii::app()->clientScript->registerScript('init', "
	
    	$('.creandoBarras').each(//crea las barras de tabla actividades
    	function(){  
   			
    		var valoresCadena = $(this).attr('valIndicador');
    		var valoresArray=valoresCadena.split('-');
    		var valIndicador = valoresArray[0];
    		var esperadoX = valoresArray[1];
   			var idBarra = $(this).attr('id');
	    	var selector = '#' + idBarra + ' > div';
	    	$(this).progressbar({value:parseFloat(valIndicador)});
    		if(esperadoX!='S.I.'&&valIndicador!='S.I.'){//si vienen datos para realizar el calculo
    			
	    		var e = parseFloat(esperadoX);
    			var p = parseFloat(10);
    			var p2 = parseFloat(100);
    			var total = (e*p)/p2;

    			if(parseFloat(valIndicador)>=e){//si el avance actual es mayor o igual al avance esperado
    				
    				$(selector).css({ 'background':'#009e0f'});
    			
    			}else{
    				if(parseFloat(valIndicador)<e&&parseFloat(valIndicador)+total>=e){//si el avance actual es menor que el esperado en un rango del 10 %
    					
    					$(selector).css({ 'background': '#ffff00' });
    				
    				}else{//sino es rojo
    					
    					$(selector).css({ 'background': '#cc0000' });
    				}
    			}
    		}else{//si no vienen datos para realizar el calculo
			
    		}
 
  			$(this).css({ 'height': '25px' });
  			$(this).css({ 'width': '150px' });
  				
    
    	});
");

date_default_timezone_set("America/Santiago");

$mes = date("F");
$anio = date("Y");
$dia = date("d");
if ($mes=="January") $mes="Enero";
if ($mes=="February") $mes="Febrero";
if ($mes=="March") $mes="Marzo";
if ($mes=="April") $mes="Abril";
if ($mes=="May") $mes="Mayo";
if ($mes=="June") $mes="Junio";
if ($mes=="July") $mes="Julio";
if ($mes=="August") $mes="Agosto";
if ($mes=="September") $mes="Setiembre";
if ($mes=="October") $mes="Octubre";
if ($mes=="November") $mes="Noviembre";
if ($mes=="December") $mes="Diciembre";
$fecha = $mes.' '.$dia.' de '.$anio;

$this->breadcrumbs = array(
		Yii::t('ui','Reportes')=>array('/reportes'),
		Yii::t('ui','Seguimiento Plan de Mejora')=>array('/seguimientoPlanMejora/'),
		'Detalle AMI/LA',
	);
?>
<div style="float:right;" id='contenedoricono' class='botoenesReportecdc'>
<div style="float:left">Exportar a:&nbsp&nbsp&nbsp</div>
<a id="linkExcel"  name="linkExcel" title="Exportar a Pdf" href="<?php  echo Yii::app()->request->baseUrl.'/seguimientoPlanMejora/reportes?pdf=1&fecha='.$fecha; ?>" >
<div class="iconoPdf" id ="iconoPdf" style="float:right"></div></a>
<a id="linkExcel"  name="linkExcel" title="Exportar a MS Word" href="<?php echo Yii::app()->request->baseUrl.'/seguimientoPlanMejora/reportes?doc=1&fecha='.$fecha; ?>" >
<div class="iconoWord" id ="iconoWord" style="float:right"></div></a>
</div>
<br></br>

<h3 rel="DETALLES ACCIÓN DE MEJORA INMEDIATA"><?php echo $datosAmi[0]['nombre']; ?></h3>
<table width="900" height="114" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
  <tr>
    <td height="21" colspan="4" bgcolor="#6095BD" class="textoReportesTablas"><center><?php echo $titulo; ?></center></td>
  </tr>
  <tr>
    <td width="294" height="21" bgcolor="#6095BD" class="textoReportesTablas">Gobierno Regional</td>
    <td colspan="3">&nbsp; Gobierno Regional de Los Lagos</td>
  </tr>
 <tr>
  <td height="21" bgcolor="#6095BD" class="textoReportesTablas">Acción de Mejora Inmediata</td>
    <td colspan="3">&nbsp;<?php echo $datosAmi[0]['nombre'].' ',$datosAmi[0]['descripcion']; ?></td>
  </tr>
  <tr>
    <td height="21" bgcolor="#6095BD" class="textoReportesTablas">Fecha de Seguimiento</td>
    <td width="172">&nbsp;<?php echo $fecha; ?></td>
    <td width="171" bgcolor="#6095BD" class="textoReportesTablas">Encargado de Seguimiento</td>
    <td width="174">&nbsp;<?php echo $datosAmi[0]['r_mantencion']; ?></td>
  </tr>
  <tr>
    <td colspan="4">
    <!-- inicio tabla intermedia -->
    <div style="max-height:500px;overflow:auto;height:auto;">
    <table width="900" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC" align="center">
      <tr>
        <td width="133" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Actividad</center></td>
        <td colspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Ejecución</center></td>
        <td width="135" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Indicador</center></td>
        <td width="99" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Meta</center></td>
        <td width="124" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Resultado Medición</center></td>
        <td width="115" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center>Nivel de Logro</center></td>
      </tr>
      <tr>
        <td width="112" bgcolor="#6095BD" class="textoReportesTablas"><center>Inicio</center></td>
        <td width="89" bgcolor="#6095BD" class="textoReportesTablas"><center>Término</center></td>
        </tr>
        <?php 
       	  $actividades = Actividades::model()->actividadesHitos($mes, $datosAmi[0]['id_indicador']);
       	 
	      if(count($actividades->getData())!=0){
			
			$actividades = $actividades->getData();
			
	      $totalMonto=0.0;
	      
	      for($k=0; $k<count($actividades); $k++){ 
	    
	      	if(is_null($actividades[$k]['avance_actual'])){
	      	
				$actividades[$k]['avance_actual']='S.I.';
				$actividades[$k]['value']=$actividades[$k]['avance_actual'];
			}
			if(!is_null($actividades[$k]['fecha_inicio'])&&!is_null($actividades[$k]['fecha_termino'])&&!is_null($fecha)){
				
				$fechaIni=strtotime($actividades[$k]['fecha_inicio']);
				$fechaFin=strtotime($actividades[$k]['fecha_termino']);
				$fechaHoy =strtotime($fecha);
			
					if($fechaHoy>$fechaFin){//caso exepcional si la fecha actual es despues de la fecha de termino
					
						$diasTotales = ((strtotime($actividades[$k]['fecha_termino'])-strtotime($actividades[$k]['fecha_inicio']))/86400);
					    $diasCorridos = $diasTotales;
					    if($diasTotales != 0){
					  		$esperadoX = ($diasCorridos*100)/$diasTotales;
					  	}else{

							$esperadoX = 0;//RCP($diasCorridos*100)/1;
						}
					}
					else{
					
						if($fechaHoy<$fechaIni){//este es caso exepcional si la fecha actual es antes de la fecha de inicio
								  
						  	$esperadoX = 0;	
							
						}else{//si no es un caso normal
					
									$diasTotales = ((strtotime($actividades[$k]['fecha_termino'])-strtotime($actividades[$k]['fecha_inicio']))/86400);
					    			$diasCorridos = ((strtotime($fecha)-strtotime($actividades[$k]['fecha_inicio']))/86400);
					  				if($diasTotales != 0){
					    				$esperadoX = ($diasCorridos*100)/$diasTotales;	
					    			}else{
										$esperadoX = 0;//RCP ($diasCorridos*100)/1;
									}
							
						}//fin else
					}//fin else
					$actividades[$k]['esperadoX']=round($esperadoX);
					$actividades[$k]['value']=$actividades[$k]['avance_actual'];
					$actividades[$k]['avance_actual']=$actividades[$k]['avance_actual'].'-'.$esperadoX;
					
					$esperadoX = round($esperadoX);
			}else{

				$actividades[$k]['esperadoX']='S.I.';
				$actividades[$k]['value']=$actividades[$k]['avance_actual'];
				$actividades[$k]['avance_actual']=$actividades[$k]['avance_actual'].'-'.'S.I.';
				
			}
	      	
	      
	   ?>
	      <tr>
	        <td>&nbsp;<?php echo $actividades[$k]['actividad']; ?></td>
	        <td>&nbsp;<?php echo $actividades[$k]['fecha_inicio']; ?></td>
	        <td>&nbsp;<?php echo $actividades[$k]['fecha_termino']; ?></td>
	        <td>&nbsp;</td>
	        <td>&nbsp;100%</td>
	        <td>&nbsp;<?php echo $actividades[$k]['value']; ?></td>
	        <td>&nbsp;
	        <!-- creando barras de progreso -->
	        <p>
	        <div class="grafico_indicador">
				<?php 
				if($actividades[$k]['value'] != 'S.I.'){
				?>
					<div class="porcentaje_indicador"><?php echo $actividades[$k]['value'];?>%</div>
				<?php } else{
				?>
					<div class="porcentaje_indicador">S.I.</div>
				<?php }?>
					<div id="<?php echo 'barra'.$k; ?>"  class="creandoBarras" valIndicador="<?php echo $actividades[$k]['avance_actual'];?>"></div>	
			</div>
			</p>
	
	        <!-- fin barra progreso -->
	        </td>
	      </tr>
      <?php 
	      }//fin for     
	      }else{
	   ?>
	   	<tr>
     	 <td colspan="8">&nbsp;No se encontraron registros de actividades</td>
     	 </tr>
	   <?php
	      }//fin else
      ?>
    </table>
    </div>
    <!-- fin tabla -->
    </td>
  </tr>
</table>
<br />
<br />
<input id="botonComentario" class="update"  type="button" value="Comentarios" href="<?php  echo Yii::app()->request->baseUrl.'/seguimientoPlanMejora/addComentario?IndicadoresObservaciones[id_indicador]='.$datosAmi[0]['id_indicador'].'&IndicadoresObservaciones[bandera]=1&IndicadoresObservaciones[id_usuario]='.$datosAmi[0]['responsable_id'].'&IndicadoresObservaciones[tipo_observacion]=2&titulo=Comentarios' ?>">
																									
<input id="botonComentario" class="update"  type="button" value="Observaciones" href="<?php  echo Yii::app()->request->baseUrl.'/seguimientoPlanMejora/addComentario?IndicadoresObservaciones[id_indicador]='.$datosAmi[0]['id_indicador'].'&IndicadoresObservaciones[bandera]=1&IndicadoresObservaciones[id_usuario]='.$datosAmi[0]['responsable_id'].'&IndicadoresObservaciones[tipo_observacion]=1&titulo=Observaciones' ?>">
<input id="botonIndicadorAmi" class="update" type="button" value="Indicador" href="<?php  echo Yii::app()->request->baseUrl.'/seguimientoPlanMejora/viewIndicador?idi='.$datosAmi[0]['id_indicador']; ?>">
