<div class="form">
<h3 rel="DETALLES ACCIÓN DE MEJORA INMEDIATA"><?php echo $datosAmi[0]['nombre']; ?></h3>
<table width="759" height="340" border="1" bordercolor="#4882AC" cellpadding="0" cellspacing="0" align="center" >
  <tr>
    <td colspan="3" align="center" bgcolor="#6095BD" class="textoReportesTablas"><strong>ACCIÓN DE MEJORA INMEDIATA (AMI)</strong></td>
  </tr>
  <tr bgcolor="#E5F1F4">
    <td colspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas"><strong>Nombre de la AMI</strong></td>
    <td>&nbsp;<?php echo $datosAmi[0]['nombre'] ?></td>
  </tr>
  <tr bgcolor="#FBFBEF">
    <td width="110" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas"><strong>Responsable</strong></td>
    <td width="175" align="center" bgcolor="#6095BD" class="textoReportesTablas"><strong>Implementación</strong></td>
    <td width="467">&nbsp;<?php echo $datosAmi[0]['r_implementacion'] ?></td>
  </tr>
  <tr bgcolor="#E5F1F4">
    <td align="center" bgcolor="#6095BD" class="textoReportesTablas"><strong>Mantención</strong></td>
    <td width="467">&nbsp;<?php echo $datosAmi[0]['r_mantencion'] ?></td>
  </tr>
  <tr bgcolor="#FBFBEF">
    <td height="40" width="110" align="center" bgcolor="#6095BD" class="textoReportesTablas"><strong>Caracterización</strong></td>
    <td colspan="2">&nbsp;<?php echo $datosAmi[0]['descripcion'] ?></td>
  </tr>
  <tr bgcolor="#E5F1F4">
    <td height="44" align="center" bgcolor="#6095BD" class="textoReportesTablas"><strong>Criterio(s)</strong></td>
    <td colspan="2">&nbsp;
    <?php 
    	$criterios = LaElemGestion::Model()->getCriterios($id);
    	
    	if(isset($criterios)&&count($criterios)!=0){
	    	for($j=0; $j<count($criterios);$j++){
	    		
	    		if($j==0){
	    			echo $criterios[$j]['crit'];
	    		}else{
	    			echo ',&nbsp;'.$criterios[$j]['crit'];
	    		}
	    	}
    	}else{
    		 echo 'Si información';
    	}
    
    ?>
    </td>
  </tr>
  <tr bgcolor="#FBFBEF">
    <td height="39" align="center" bgcolor="#6095BD" class="textoReportesTablas"><strong>Subcriterio(s)</strong></td>
    <td colspan="2">&nbsp;
    <?php 
    
    	$subcriterios = LaElemGestion::Model()->getSubcriterios($id);
    	
    	if(isset($subcriterios)&&count($subcriterios)!=0){
	    	for($k=0; $k <count($subcriterios);$k++){
	    		
	    		if($k==0){
	    			echo $subcriterios[$k]['sub'];
	    		}else{
	    			echo ',&nbsp;'.$subcriterios[$k]['sub'];
	    		}
	    		
	    	}
    	}else{
    		
    		echo 'Sin información';
    	}
    
    ?>
    </td>
  </tr>
  <tr bgcolor="#E5F1F4">
    <td height="52" colspan="3">

<!-- comienza tabla de elementos gestion -->
	
	<?php 
		$elementos=LaElemGestion::model()->elementosGestionPorAmi($id);
		
	?>
	<div style="max-height:500px;overflow:auto;height:auto;">
	<table width="756" height="62" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
	
	<?php 
	$indicadores = array();
	$indicadores[0]['puntaje_esperado'] = 0;
	if(count($elementos)!=0){
		for($i=0; $i<count($elementos); $i++){
		//	echo ' elemento '.$elementos[$i]['idElem'];
			$colorTr="#FBFBEF";
			if(($i+1)%2==1){
				$colorTr="#E5F1F4";
			}else{
				$colorTr="#FBFBEF";
			}
		//	echo ' id eelemento gestion '.$elementos[$i]['idElem'];
		//	echo ' puntaje elemento '.$elementos[$i]['puntaje_elemento'];
			$indicadores = LaElemGestion::model()->findAll(array('condition'=>'t.estado = 1 AND t.id_la IS NOT NULL AND t.id_elem_gestion='.$elementos[$i]['idElem'].' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'select'=>'t.puntaje_esperado'));
		?>
	  <tr bgcolor="<?php echo $colorTr; ?>">
	    <td width="113" height="60" align="center" bgcolor="#6095BD"><strong class="textoReportesTablas">Elemento de Gestión</strong></td>
	    <td width="175"><?php echo $elementos[$i]['elemento']?></td>
	    <td width="83" align="center" bgcolor="#6095BD"><strong class="textoReportesTablas">Puntaje Actual</strong></td>
	    <td width="70" align="center"><?php echo $elementos[$i]['puntaje_actual']?></td>
	    <td width="87" align="center" bgcolor="#6095BD"><strong class="textoReportesTablas">Puntaje Esperado</strong></td>
	    <td width="81" align="center"><?php echo $indicadores[0]['puntaje_esperado']?></td>
	    <td width="77" align="center" bgcolor="#6095BD"><strong class="textoReportesTablas">Delta Ponderado</strong></td>
	    <td width="69" align="center"><?php 
	    
	    	$resultado = 0.0;
	    	
	    	$resultado = ($indicadores[0]['puntaje_esperado']- $elementos[$i]['puntaje_actual'])* $elementos[$i]['puntaje_elemento'];
	    
	    	echo $resultado;
	    ?></td>
	  </tr>
	  <?php }//fin for

	    }//fin if
	    else{
			?>
		<tr>
		<td colspan="8">
		No se encontraron registros de elementos de gestión
		</td>
		</tr>
			<?php 
		}?>
	</table>
	</div>
<!-- fin tabla elementos de gestion -->
    
    </td>
  </tr>
  <tr bgcolor="#E5F1F4">
    <td height="39" colspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas"><strong>Medio de Verificación</strong></td>
    <td height="39">&nbsp;<?php echo $datosAmi[0]['medio_verificacion'] ?></td>
  </tr>
  <tr bgcolor="#FBFBEF">
    <td height="40" colspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas"><strong>Fecha de Ejecución</strong></td>
    <td height="40">&nbsp;</td>
  </tr>
</table>
</div>