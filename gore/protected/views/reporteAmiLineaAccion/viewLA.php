<?php 
$elementos=LaElemGestion::model()->elementosGestionPorAmi($id);
?>
<div class="form">
<h3 rel="DETALLES ACCIÓN DE MEJORA INMEDIATA"><?php echo $lineas[0]['nombre']; ?></h3>
<table width="851" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
  <tr>
    <td colspan="4" align="center" bgcolor="#6095BD" class="textoReportesTablas">REGISTRO DE LÍNEA DE ACCIÓN</td>
  </tr>
  <tr>
    <td width="278" bgcolor="#6095BD" class="textoReportesTablas">Línea Acción</td>
    <td colspan="3">&nbsp;<?php echo $lineas[0]['nombre']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#6095BD" class="textoReportesTablas">Área de Mejora</td>
    <td colspan="3">&nbsp;
    <?php 
    	$sub = LaElemGestion::model()->getSubcriterios($id);
    
    		for($k=0; $k <count($sub);$k++){
	    		
	    		if($k==0){
	    			echo $sub[$k]['sub'];
	    		}else{
	    			echo ',&nbsp;'.$sub[$k]['sub'];
	    		}
	    		
	    	}
    ?>
    </td>
  </tr>
  <tr>
    <td bgcolor="#6095BD" class="textoReportesTablas">Período de Ejecución</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#6095BD" class="textoReportesTablas">Responsable Línea de Acción</td>
    <td colspan="3">&nbsp;<?php echo $lineas[0]['r_implementacion']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#6095BD" class="textoReportesTablas">Actores Internos</td>
    <td colspan="3">&nbsp;
    <?php 
    
    $actores = '';
    $actores = User::Model()->getActoresLA($id);
    
    echo $actores;
    
    ?>
    </td>
  </tr>
  <tr>
    <td bgcolor="#6095BD" class="textoReportesTablas">Indicador Cumplimiento</td>
    <td width="266">&nbsp;<?php  
    //buscando el indicador
    $indicador = '';

    	$indicador = TiposFormulas::model()->columnaFormulaReporteReport($lineas[0]['id_indicador'], 1);
    
    echo $indicador;
    
    ?></td>
    <td width="149" bgcolor="#6095BD" class="textoReportesTablas">Valor Meta</td>
    <td width="150">&nbsp;<?php echo $lineas[0]['meta_anual']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#6095BD" class="textoReportesTablas">Medio de Verificación</td>
    <td colspan="3">&nbsp;<?php echo $lineas[0]['medio_verificacion']; ?></td>
  </tr>
  <tr>
    <td colspan="4"><?php echo $lineas[0]['descripcion']; ?></td>
  </tr>
  <tr>
    <td colspan="4">
    <div style="max-height:500px;overflow:auto;height:auto;">
    <table width="848" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
    
    <?php 
    $ultimoEsperado = array();
    $ultimoEsperado[0]['puntaje_esperado'] = 0;
    if(isset($elementos)&&count($elementos)!=0){
    	for($i=0; $i<count($elementos); $i++){

	$ultimoEsperado = LaElemGestion::model()->findAll(array('condition'=>'t.estado = 1 AND t.id_la IS NOT NULL AND t.id_elem_gestion='.$elementos[$i]['idElem'].' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'select'=>'t.puntaje_esperado'));
		//$ultimoEsperado = LaElemGestion::model()->findAll(array('condition'=>'t.estado=1 AND t.puntaje_revisado IS NOT NULL AND t.id_elem_gestion='.$elementos[$i]['idElem'].' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'order'=>'t.fecha DESC','select'=>'t.puntaje_esperado'));
    ?>
      <tr>
        <td width="75" align="center" bgcolor="#6095BD" class="textoReportesTablas">Elemento de Gestión</td>
        <td width="155">&nbsp;<?php echo $elementos[$i]['elemento']?></td>
        <td width="84" align="center" bgcolor="#6095BD" class="textoReportesTablas">Puntaje Actual</td>
        <td width="118">&nbsp;<?php echo $elementos[$i]['puntaje_actual']?></td>
        <td width="95" align="center" bgcolor="#6095BD" class="textoReportesTablas">Puntaje Esperado</td>
        <td width="129">&nbsp;<?php echo $ultimoEsperado[0]['puntaje_esperado']?></td>
        <td width="81" align="center" bgcolor="#6095BD" class="textoReportesTablas">Delta Ponderado</td>
        <td width="93">&nbsp;<?php 
	    
	    	$resultado = 0.0;
	    	
	    	$resultado = ($ultimoEsperado[0]['puntaje_esperado']- $elementos[$i]['puntaje_actual'])* $elementos[$i]['puntaje_elemento'];
	    
	    	echo $resultado;
	    ?></td>
      </tr>
      
      <?php 
      
    	}
	    }else{//fin if
	   ?> 	
	   <tr>No se han encontrado registros de elementos de gestión</tr>
	   <?php 
	    }
      ?>
    </table>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="4">
    <div style="max-height:500px;overflow:auto;height:auto;">
    <table width="847" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
      <tr>
        <td rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Actividad</td>
        <td colspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Ejecución</td>
        <td rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Indicador</td>
        <td rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Meta</td>
        <td colspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Recursos MS</td>
        <td rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Responsable</td>
        </tr>
      <tr>
        <td align="center" bgcolor="#6095BD" class="textoReportesTablas">Inicio</td>
        <td align="center" bgcolor="#6095BD" class="textoReportesTablas">Término</td>
        <td align="center" bgcolor="#6095BD" class="textoReportesTablas">Propios</td>
        <td align="center" bgcolor="#6095BD" class="textoReportesTablas">AGES</td>
      </tr>
      <?php 
      
      $actividades = Actividades::model()->findAll(array('condition'=>'t.estado = 1 AND t.indicador_id='.$lineas[0]['id_indicador'],'select'=>'CONCAT(t.nombre, " ", t.descripcion) AS actividad, t.indicador_id, t.fecha_inicio, t.fecha_termino, t.id'));
      
      //$actividades = Indicadores::model()->actividadesIndicador($lineas[0]['id_indicador']);
      $totalMonto=0.0;
      if(isset($actividades)&&count($actividades)!=0){
      
      for($k=0; $k<count($actividades); $k++){ ?>
      <tr>
        <td>&nbsp;<?php echo $actividades[$k]['actividad']; ?></td>
        <td>&nbsp;<?php echo $actividades[$k]['fecha_inicio']; ?></td>
        <td>&nbsp;<?php echo $actividades[$k]['fecha_termino']; ?></td>
        <td>&nbsp;<?php  ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;
        <?php 
			
	        $suma = ItemesActividades::model()->sumaMontoPorActividad($actividades[$k]['id']);
	        if(isset($suma)){
	        	echo $suma[0]['sumaMonto'];
	        	$totalMonto = $totalMonto+($suma[0]['sumaMonto']);
	        }
        	
        ?>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;<?php echo $lineas[0]['r_implementacion']; ?></td>
      </tr>

      <?php } 
      }else{
      
      ?>	
      <tr>
      <td colspan="8">&nbsp;No se encontraron registros de actividades</td>
      </tr>
      <?php 
      }
      ?>
      <tr>
        <td colspan="5" bgcolor="#6095BD" class="textoReportesTablas">Totales</td>
        <td>&nbsp;<?php echo $totalMonto ?></td>
        <td>&nbsp;</td>
        <td bgcolor="#6095BD">&nbsp;</td>
      </tr>
    </table>
    </div>
    </td>
  </tr>
</table>
</div>