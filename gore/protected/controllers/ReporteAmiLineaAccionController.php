<?php
include dirname(Yii::app()->request->scriptFile).'/protected/views/panelAvances/ConsultasView.php';

class ReporteAmiLineaAccionController extends GxController {

    public function filters() {
    return array(
            'accessControl', 
            );
    }
    
    public function accessRules() {                  
          return array(
            array('allow',
                'actions'=>array('index','reportes', 'update', 'viewla'),    
            	'roles'=>array('gestor','finanzas','supervisor','supervisor2'),  
            ),             
            array('deny',
                'users'=>array('*'),
            ),
        );
    }  


public function actionIndex() {

		
		$this->render('index'
		);
}

public function actionUpdate($id){
	
		$datosAmi= LineasAccion::model()->unaAmiDetalles($id, 0);
		
		$this->layout = '//layouts/iframe';
       	$this->render('view', array(
                'datosAmi'=>$datosAmi,
       			'id'=>$id,
       		
     
        ));
}

public function actionViewla($id){
	$lineas = LineasAccion::model()->lineasIndicador($id);
		$this->layout = '//layouts/iframe';
		    	$this->render('viewLA', array(
                'lineas'=>$lineas,
		    	'id'=>$id
     
        ));
}

public function actionReportes(){
	
	$model = new LineasAccion('busquedaReporteAMILA');
	$model->id_tipo_la=1;
	$datos = $model->busquedaReporteAMILA();	
	$lineas= LineasAccion::model()->unaAmiDetalles(0, 0);	
	$datosImprimir = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
	$tablaResumenAmi='';
	$tablaResumenLA='';
	$tablaDetallesAmi='';
	$tablaDetallesLA='';
	$mantenedorAMIS='';
	$mantenedorLA = '';
	$sumaTotales = '';
	$totalActual=0.0;
	$totalEsperado=0.0;
	$totalPonderado=0.0;
	$i=0;
	
	/**
	 * creando mantenedor AMIS
	 */
	
	$mantenedorAMIS = $mantenedorAMIS.'<table width="1100" height="77" border="1" cellpadding="0" cellspacing="0" align="center">
  									<tr><td height="23" colspan="6" align="center" bgcolor="#CCCCCC"><strong>ACCIONES DE MEJOR INMEDIATA DEL GORE</strong></td></tr>
									<tr><td height="44" bgcolor="#CCCCCC"><strong>NOMBRE DE LA AMI</strong></td>
    								<td bgcolor="#CCCCCC"><strong>CRITERIO(S) SUBCRITERIO(S)</strong></td>
    								<td bgcolor="#CCCCCC"><strong>RESPONSABLE IMPLEMENTACIÓN</strong></td>
    								<td bgcolor="#CCCCCC"><strong>RESPONSABLE MANTENCION</strong></td>
    								<td bgcolor="#CCCCCC"><strong>PLAZO DE EJECUCIÓN</strong></td>
    								<td bgcolor="#CCCCCC"><strong>DELTA P PONDERADO</strong></td></tr>';
	
				$amis = LineasAccion::model()->busquedaAmiReporte(0);
				$amis = $amis->getData();
	
	$mantenedorAMIS = $mantenedorAMIS.'';
				for($g=0; $g<count($amis); $g++){//recorriendo las lineas de accion, todas

					$mantenedorAMIS = $mantenedorAMIS.' <tr><td height="31">&nbsp;'.$amis[$g]['nombre'].'</td>
														<td>&nbsp;';
														$critSub='';
														$critSub = LaElemGestion::model()->obtieneCriteriosPorElementosGestionAmiReport($amis[$g]['id']);
														
					$mantenedorAMIS = $mantenedorAMIS.$critSub.'</td><td>&nbsp;'.$amis[$g]['r_implementacion'].'</td>
													    <td>&nbsp;'.$amis[$g]['r_mantencion'].'</td>
													    <td>&nbsp;</td>
													    <td>&nbsp;';
														$dp='';
													    $dp= LaElemGestion::model()->obtienePonderacionPorElementosGestionAmi($amis[$g]['id'], -1);
													    
													    
					$mantenedorAMIS = $mantenedorAMIS.$dp.'</td></tr>';					
				}//fin for
				
				
	$mantenedorAMIS = $mantenedorAMIS.'</table>';

	
	/**
	 * creando la tabla resumen AMI
	 */
	$tablaResumenAmi = $tablaResumenAmi.'<table height="185" border="1" cellpadding="0" cellspacing="0" align = "center">
		  								 <tr><td height="23" colspan="5" align="center" bgcolor="#CCCCCC"><strong>SÍNTESIS DE AMI</strong></td></tr>
		  								 <tr><td bgcolor="#CCCCCC"><strong>Gobierno Regional</strong></td><td colspan="4">&nbsp;Gobierno Regional de Los Lagos</td></tr>
		  								 <tr><td bgcolor="#CCCCCC"><strong>Fecha</strong></td><td colspan="4">&nbsp;'.$_GET['fecha'].'</td></tr>
		  								 <tr><td bgcolor="#CCCCCC"><strong>Responsable</strong></td><td colspan="4">&nbsp;</td></tr>
		  								 <tr><td colspan="5">
		    							 <table border="1"  width="1100" cellpadding="0" cellspacing="0">
									     <tr>
									        <td  rowspan="2" align="center" bgcolor="#CCCCCC"><strong>AMI / Líneas de Aciión</strong></td>
									        <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Elemento de Gestión</strong></td>
									        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Puntaje</strong></td>
									        <td  rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Delta Ponderado</strong></td>
									        <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Fecha de Cumplimiento</strong></td>
									     </tr>
									     <tr>
									        <td align="center" bgcolor="#CCCCCC"><strong>Actual</strong></td>
									        <td align="center" bgcolor="#CCCCCC"><strong>Esperado</strong></td>
									     </tr>';
		         
		    
	foreach($datos->getData() as $lineas): 

		$elementos = LaElemGestion::model()->elementosGestionPorAmi($lineas->id);
		      
	$tablaResumenAmi=$tablaResumenAmi.'<tr><td>&nbsp;'.$lineas->nombre.'</td>
									   <td>&nbsp;';
				     		$criteriosSub='';
				        	for($k=0; $k<count($elementos); $k++){

					        		if($k==0){
					        			$criteriosSub = $criteriosSub.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        		}else{
					        			
					        			if(($k+1)%3==0){
					        				$criteriosSub=$criteriosSub.';<br/>&nbsp;&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        			}else{
					        				$criteriosSub = $criteriosSub.';&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        			}
					        		}
				        		
				        	}//fin for
	$tablaResumenAmi=$tablaResumenAmi.$criteriosSub.'</td><td>&nbsp;';
				      		$puntaje = '';
				        	for($k=0; $k<count($elementos); $k++){
				        		   		
				        		if(!is_null($elementos[$k]['puntaje_actual'])){
					        		if($k==0){
					        			$puntaje = $puntaje.$elementos[$k]['puntaje_actual'];
					        		}else{
					        			
					        			if(($k+1)%3==0){
					        				$puntaje = $puntaje.';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}else{
					        				$puntaje = $puntaje.';&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}
					        			
					        		}
					        		
					        		$totalActual = $totalActual+$elementos[$k]['puntaje_actual'];
				        		}
				        	}
	$tablaResumenAmi=$tablaResumenAmi.$puntaje.'</td><td>&nbsp;';
				        	$puntajeEsperado = '';
				        	for($k=0; $k<count($elementos); $k++){
				        		if(!is_null($elementos[$k]['puntaje_esperado'])){
					        		if($k==0){
					        			$puntajeEsperado=$puntajeEsperado.$elementos[$k]['puntaje_esperado'];
					        		}else{
					        			if(($k+1)%3==0){
					        				$puntajeEsperado=$puntajeEsperado.';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_esperado'];
					        			}else{
					        				$puntajeEsperado=$puntajeEsperado.';&nbsp;'.$elementos[$k]['puntaje_esperado'];
					        			}
					        		}
					        		$totalEsperado = $totalEsperado+$elementos[$k]['puntaje_esperado'];
				        		}
				        	}
	$tablaResumenAmi=$tablaResumenAmi.$puntajeEsperado.'</td><td>&nbsp;';
				      
				         	$resultado = 0.0;
				        	for($k=0; $k<count($elementos); $k++){
				        		$resultado = $resultado+($elementos[$k]['puntaje_esperado']-$elementos[$k]['puntaje_actual'])*$elementos[$k]['puntaje_elemento'];
				        		
				        	}
				        	$totalPonderado = $totalPonderado+$resultado;
				        	
	$tablaResumenAmi=$tablaResumenAmi.$resultado.'</td><td>&nbsp;</td></tr>';	     
	$i++;
	endforeach; 
	
	$tablaResumenAmi=$tablaResumenAmi.'<tr><td colspan="2" bgcolor="#CCCCCC"><strong>Totales:</strong></td>
						     		   <td>&nbsp;'.$totalActual.'</td>
						     		   <td>&nbsp;'.$totalEsperado.'</td>
						     		   <td>&nbsp;'.$totalPonderado.'</td>
						     		   <td>&nbsp;</td>
				   		 			   </tr>
									   </table>
									   </td>
				  					   </tr>
									   </table>';
	
	/**
	 * creando la tabla detalles AMI
	 */
	
	$datosAmi= LineasAccion::model()->unaAmiDetalles(0, 1);
	
	for($j=0; $j<count($datosAmi); $j++){
	
	$tablaDetallesLA = $tablaDetallesLA.'<br /><table  width="1100" height="340" border="1" cellpadding="0" cellspacing="0" align="center" >
  									  <tr><td colspan="3" align="center" bgcolor="#CCCCCC"><strong>ACCIÓN DE MEJORA INMEDIATA (AMI)';
									    $correlativo = 0;
										if($j<10){
											$correlativo = ' 0'.($j+1);
										}
	
  	$tablaDetallesLA = $tablaDetallesLA.$correlativo.'</strong></td></tr>
  									  <tr><td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Nombre de la AMI</strong></td>
    								  <td>&nbsp;'.$datosAmi[$j]['nombre'].'</td></tr>
  									  <tr><td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Responsable</strong></td>
    								  <td  align="center" bgcolor="#CCCCCC"><strong>Implementación</strong></td>
    								  <td>&nbsp;'.$datosAmi[$j]['r_implementacion'].'</td></tr>
  									  <tr><td align="center" bgcolor="#CCCCCC"><strong>Mantención</strong></td>
    								  <td>&nbsp;'.$datosAmi[$j]['r_mantencion'].'</td></tr>
  									  <tr><td height="40" align="center" bgcolor="#CCCCCC"><strong>Caracterización</strong></td>
    								  <td colspan="2">&nbsp;'.$datosAmi[$j]['descripcion'].'</td>
  									  </tr><tr><td height="44" align="center" bgcolor="#CCCCCC"><strong>Criterio(s)</strong></td>
    								  <td colspan="2">&nbsp;';
  
					    	$criterios = LaElemGestion::Model()->getCriterios($datosAmi[$j]['id']);
					    	
					    	$crt='';
					    	if(isset($criterios)&&count($criterios)!=0){
						    	for($p=0; $p<count($criterios);$p++){
						    		
						    		if($p==0){
						    			$crt = $crt.$criterios[$p]['crit'];
						    		}else{
						    			$crt = $crt.',&nbsp;'.$criterios[$p]['crit'];
						    		}
						    	}
					    	}else{
					    		 $crt = $crt.'Si información';
					    	}
    
 
   $tablaDetallesLA = $tablaDetallesLA.$crt.'</td></tr><tr><td height="39" align="center" bgcolor="#CCCCCC"><strong>Subcriterio(s)</strong></td>
    								<td colspan="2">&nbsp;';
    
					    	$subcriterios = LaElemGestion::Model()->getSubcriterios($datosAmi[$j]['id']);
					    	$src='';
					    	if(isset($subcriterios)&&count($subcriterios)!=0){
						    	for($k=0; $k <count($subcriterios);$k++){
						    		
						    		if($k==0){
						    			$src = $src.$subcriterios[$k]['sub'];
						    		}else{
						    			$src = $src.',&nbsp;'.$subcriterios[$k]['sub'];
						    		}
						    		
						    	}
					    	}else{
					    		
					    		$src = $src.'Sin información';
					    	}

   $tablaDetallesLA = $tablaDetallesLA.$src.'</td></tr><tr><td height="52" colspan="3">';

							$elementos=LaElemGestion::model()->elementosGestionPorAmi($datosAmi[$j]['id']);

	
   $tablaDetallesLA = $tablaDetallesLA.'<table height="62" border="1" cellpadding="0" cellspacing="0">';
	
   for($i=0; $i<count($elementos); $i++){
			
   $tablaDetallesLA = $tablaDetallesLA.'<tr><td width="113" height="60" align="center" bgcolor="#CCCCCC"><strong>Elemento de Gestión</strong></td>
	    							<td>'.$elementos[$i]['elemento'].'</td>
	    							<td align="center" bgcolor="#CCCCCC"><strong>Puntaje Actual</strong></td>
	    							<td align="center">'.$elementos[$i]['puntaje_actual'].'</td>
	    							<td align="center" bgcolor="#CCCCCC"><strong>Puntaje Esperado</strong></td>
	    							<td align="center">'.$elementos[$i]['puntaje_esperado'].'</td>
	    							<td align="center" bgcolor="#CCCCCC"><strong>Delta Ponderado</strong></td>
	    							<td align="center">'; 
					    
					    	$resultado = 0.0;
					    	
					    	$resultado = ($elementos[$i]['puntaje_esperado']- $elementos[$i]['puntaje_actual'])* $elementos[$i]['puntaje_elemento'];
					    
	$tablaDetallesLA = $tablaDetallesLA.$resultado.'</td></tr>';
	}//fin for 
	$tablaDetallesLA = $tablaDetallesLA.'</table></td></tr><tr>
								    <td height="39" colspan="2" align="center" bgcolor="#CCCCCC"><strong>Medio de Verificación</strong></td>
								    <td height="39">&nbsp;'.$datosAmi[$j]['medio_verificacion'].'</td></tr>
								  	<tr><td height="40" colspan="2" align="center" bgcolor="#CCCCCC"><strong>Fecha de Ejecución</strong></td>
								    <td height="40">&nbsp;</td></tr></table>';
	}//fin for
	
	
	/**
	 * creando la tabla mantenedor LA
	 */
	
	$mantenedorLA = $mantenedorLA.'<table width="1100" border="1" cellpadding="0" cellspacing="0" align="center">
								  <tr><td height="23" colspan="3" align="center" bgcolor="#CCCCCC"><strong>ÁREAS DE MEJORA SELECCIONADAS DEL GORE</strong></td></tr>
								  <tr><td bgcolor="#CCCCCC"><strong>ÁREA DE MEJORA</strong></td>
								  <td bgcolor="#CCCCCC"><strong>RESPONSABLE</strong></td>
								  <td bgcolor="#CCCCCC"><strong>LÍNEA DE ACCIÓN</strong></td></tr>';
	
							$lineasAccion_m = LineasAccion::model()->busquedaAmiReporte(1);
							$lineasAccion_m = $lineasAccion_m->getData();
							
							for($t=0; $t<count($lineasAccion_m); $t++){
							$mantenedorLA = $mantenedorLA.'<tr><td>&nbsp;';
								
								$crtSubCr = '';
								$crtSubCr = LaElemGestion::model()->obtieneCriteriosPorElementosGestionAmiReport($lineasAccion_m[$t]['id']);
														   
							$mantenedorLA = $mantenedorLA.$crtSubCr.'</td><td>&nbsp;'.$lineasAccion_m[$t]['r_implementacion'].'</td>
														   <td>&nbsp;'.$lineasAccion_m[$t]['nombre'].'</td></tr>';
								  
							}//fin for
	$mantenedorLA = $mantenedorLA.'</table>';
	
	/**
	 * creando la tabla sintesis de linea de accion
	 */

	
	$tablaResumenLA = $tablaResumenLA.'<table  height="185" border="1" cellpadding="0" cellspacing="0" align = "center">
				  					   <tr><td height="23" colspan="5" align="center" bgcolor="#CCCCCC"><strong>SÍNTESIS DE LÍNEA DE ACCIÓN</strong></td></tr>
				  					   <tr><td bgcolor="#CCCCCC"><strong>Gobierno Regional</strong></td>
				  					   <td colspan="4">&nbsp;Gobierno Regional de Los Lagos</td></tr>
				  					   <tr><td bgcolor="#CCCCCC"><strong>Fecha</strong></td>
				    				   <td colspan="4">&nbsp;'.$_GET['fecha'].'</td></tr>
				  					   <tr><td bgcolor="#CCCCCC"><strong>Responsable</strong></td>
				    				   <td colspan="4">&nbsp;</td></tr>
				  					   <tr><td colspan="5">';
	
				$model = new LineasAccion('busquedaReporteAMILA');
				$model->id_tipo_la=2;
				$datos = $model->busquedaReporteAMILA();

	$tablaResumenLA = $tablaResumenLA.'<table border="1" width="1100" cellpadding="0" cellspacing="0">
		      						   <tr><td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>AMI / Líneas de Aciión</strong></td>
		        					   <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Elemento de Gestión</strong></td>
		        					   <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Puntaje</strong></td>
		        					   <td  rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Delta Ponderado</strong></td>
		       						   <td  rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Fecha de Cumplimiento</strong></td></tr>
		      						   <tr><td align="center" bgcolor="#CCCCCC"><strong>Actual</strong></td>
		        					   <td  align="center" bgcolor="#CCCCCC"><strong>Esperado</strong></td></tr>';
	    
		     	$totalActual=0.0;
		     	$totalEsperado=0.0;
		     	$totalPonderado=0.0;
		     	$i=0;
		      	foreach($datos->getData() as $lineas): 
		      		
		      	$elementos = LaElemGestion::model()->elementosGestionPorAmi($lineas->id);

	$tablaResumenLA = $tablaResumenLA.'<tr><td>&nbsp;'.$lineas->nombre.'</td><td>&nbsp;';
				      		$crtp='';
				        	for($k=0; $k<count($elementos); $k++){
					        		if($k==0){
					        			$crtp = $crtp.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        		}else{
					        			
					        			if(($k+1)%3==0){
					        				$crtp = $crtp.';<br/>&nbsp;&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        			}else{
					        				$crtp = $crtp.';&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        			}
					        		}
				        		
				        	}
				       
	$tablaResumenLA = $tablaResumenLA.$crtp.'</td><td>&nbsp;';
				      		$actualPuntaje='';
				        	for($k=0; $k<count($elementos); $k++){
				        		
				        		if(!is_null($elementos[$k]['puntaje_actual'])){
					        		if($k==0){
					        			$actualPuntaje = $actualPuntaje.$elementos[$k]['puntaje_actual'];
					        		}else{
					        			
					        			if(($k+1)%3==0){
					        				$actualPuntaje = $actualPuntaje.';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}else{
					        				$actualPuntaje = $actualPuntaje.';&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}
					        			
					        		}
					        		
					        		$totalActual = $totalActual+$elementos[$k]['puntaje_actual'];
				        		}
				        	}
				  
	$tablaResumenLA = $tablaResumenLA.$actualPuntaje.'</td><td>&nbsp;';
				     		$esperadoPuntaje = '';
				        	for($k=0; $k<count($elementos); $k++){
				        		if(!is_null($elementos[$k]['puntaje_esperado'])){
					        		if($k==0){
					        			$esperadoPuntaje = $esperadoPuntaje.$elementos[$k]['puntaje_esperado'];
					        		}else{
					        			if(($k+1)%3==0){
					        				$esperadoPuntaje = $esperadoPuntaje.';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_esperado'];
					        			}else{
					        				$esperadoPuntaje = $esperadoPuntaje.';&nbsp;'.$elementos[$k]['puntaje_esperado'];
					        			}
					        		}
					        		$totalEsperado = $totalEsperado+$elementos[$k]['puntaje_esperado'];
				        		}
				        	}
				    
	$tablaResumenLA = $tablaResumenLA.$esperadoPuntaje.'</td><td>&nbsp;';
				         
				         	$resultado = 0.0;
				        	for($k=0; $k<count($elementos); $k++){
				        		$resultado = $resultado+(($elementos[$k]['puntaje_esperado']-$elementos[$k]['puntaje_actual'])*$elementos[$k]['puntaje_elemento']);
				        		
				        	}
				    
				        	$totalPonderado = $totalPonderado+$resultado;
				        	
	$tablaResumenLA = $tablaResumenLA.$resultado.'</td><td>&nbsp;</td></tr>';

	$i++;
	endforeach; 

	$tablaResumenLA = $tablaResumenLA.'<tr><td colspan="2" bgcolor="#CCCCCC"><strong>Totales:</strong></td>
					     		   <td>&nbsp;'.$totalActual.'</td>
					     		   <td>&nbsp;'.$totalEsperado.'</td>
					     		   <td>&nbsp;'.$totalPonderado.'</td>
					     		   <td>&nbsp;</td></tr>
		    					   </table></td></tr>
								   </table>';
	
	
	/**
	 * creando la tabla detalles Linea de Accion
	 */
	
	$datosAMILA= LineasAccion::model()->unaAmiDetalles(0, 2);	

	$indice = 1;
	foreach($datosAMILA as $d):
	
		if($indice < 10){
			$indice = ' 0'.$indice;
		}
		
	
	$tablaDetallesAmi=$tablaDetallesAmi.'<br />';
	$tablaDetallesAmi = $tablaDetallesAmi.'<table  border="1" cellpadding="0" cellspacing="0" align = "center">
  										  <tr><td colspan="4" align="center" bgcolor="#CCCCCC"><strong>REGISTRO DE LÍNEA DE ACCIÓN';
	
	$tablaDetallesAmi = $tablaDetallesAmi.$indice.'</strong></td></tr>
  										  <tr>
										  <td bgcolor="#CCCCCC"><strong>Línea Acción</strong></td>
										  <td colspan="3">&nbsp;'.$d->nombre.'</td>
  										  </tr>
										  <tr><td bgcolor="#CCCCCC"><strong>Área de Mejora</strong></td><td colspan="3">&nbsp;';

						    	$sub = LaElemGestion::model()->getSubcriterios($d->id);
						    	$crit2='';
						    	for($k=0; $k <count($sub);$k++){
							    		
							    		if($k==0){
							    			$crit2= $crit2.$sub[$k]['sub'];
							    		}else{
							    			$crit2=$crit2.',&nbsp;'.$sub[$k]['sub'];
							    		}
							    		
							    }//fin for
	$tablaDetallesAmi = $tablaDetallesAmi.$crit2.'</td></tr>
 										   <tr><td bgcolor="#CCCCCC"><strong>Período de Ejecución</strong></td>
    									   <td colspan="3">&nbsp;</td></tr>
  										   <tr><td bgcolor="#CCCCCC"><strong>Responsable Línea de Acción</strong></td>
    									   <td colspan="3">&nbsp;'.$d->r_implementacion.'</td></tr>
										   <tr>
										   <td bgcolor="#CCCCCC"><strong>Actores Internos</strong></td>
										   <td colspan="3">&nbsp;';
	
								$actores = '';
								$actores = User::model()->getActoresLA($d->id);
	$tablaDetallesAmi = $tablaDetallesAmi.$actores.'</td></tr><tr><td bgcolor="#CCCCCC"><strong>Indicador Cumplimiento</strong></td><td>&nbsp;'; 
						    	$indicador = '';
						    	$indicador = TiposFormulas::model()->columnaFormulaReporteReport($d->id_indicador, 1);

	$tablaDetallesAmi = $tablaDetallesAmi.$indicador.'</td><td bgcolor="#CCCCCC"><strong>Valor Meta</strong></td>
    									   <td>&nbsp;'.$d->meta_anual.'</td>
  										   </tr>
										   <tr>
										   <td bgcolor="#CCCCCC"><strong>Medio de Verificación</strong></td>
										   <td colspan="3">&nbsp;'.$d->medio_verificacion.'</td>
										   </tr>
										   <tr>
										   <td colspan="4">'.$d->descripcion.'</td>
										   </tr><tr><td colspan="4">
    									   <table border="1" width="1100" cellpadding="0" cellspacing="0">';
    
  
    if(isset($elementos)&&count($elementos)!=0){
    	
    	for($i=0; $i<count($elementos); $i++){
    
    $tablaDetallesAmi = $tablaDetallesAmi.'<tr><td align="center" width="200" bgcolor="#CCCCCC"><strong>Elemento de Gestión</strong></td>
        								  <td>&nbsp;'.$elementos[$i]['elemento'].'</td>
        								  <td align="center" bgcolor="#CCCCCC"><strong>Puntaje Actual</strong></td>
        								  <td>&nbsp;'.$elementos[$i]['puntaje_actual'].'</td>
        								  <td align="center" bgcolor="#CCCCCC"><strong>Puntaje Esperado</strong></td>
        								  <td>&nbsp;'.$elementos[$i]['puntaje_esperado'].'</td>
        								  <td align="center" bgcolor="#CCCCCC"><strong>Delta Ponderado</strong></td>
        								  <td>&nbsp;';
	    	$resultado = 0.0;
	    	$resultado = ($elementos[$i]['puntaje_esperado']- $elementos[$i]['puntaje_actual'])* $elementos[$i]['puntaje_elemento'];
	 
	$tablaDetallesAmi = $tablaDetallesAmi.$resultado.'</td></tr>';
	
    	}//fin for
	}else{//fin if
	  	
	$tablaDetallesAmi = $tablaDetallesAmi.'<tr>No se han encontrado registros de elementos de gestión</tr>';
	  
	 }//fin else
  
	 $tablaDetallesAmi = $tablaDetallesAmi.'</table></td></tr><tr><td colspan="4">
   									     <table border="1" width="1100" cellpadding="0" cellspacing="0">
									     <tr>
									     <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Actividad</strong></td>
									     <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Ejecución</strong></td>
									     <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Indicador</strong></td>
									     <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Meta</strong></td>
									     <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Recursos MS</strong></td>
									     <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Responsable</strong></td>
									     </tr>
									     <tr>
									     <td align="center" bgcolor="#CCCCCC"><strong>Inicio</strong></td>
									     <td align="center" bgcolor="#CCCCCC"><strong>Término</strong></td>
									     <td align="center" bgcolor="#CCCCCC"><strong>Propios</strong></td>
									     <td align="center" bgcolor="#CCCCCC"><strong>AGES</strong></td>
									     </tr>';
      
       $actividades = Actividades::model()->findAll(array('condition'=>'t.estado = 1 AND t.indicador_id='.$d->id_indicador,'select'=>'CONCAT(t.nombre, " ", t.descripcion) AS actividad, t.indicador_id, t.fecha_inicio, t.fecha_termino, t.id'));
       $totalMonto=0.0;
      if(isset($actividades)&&count($actividades)!=0){
     
      for($k=0; $k<count($actividades); $k++){
      
      $tablaDetallesAmi = $tablaDetallesAmi.'<tr>
								        <td>&nbsp;'.$actividades[$k]['actividad'].'</td>
								        <td>&nbsp;'.$actividades[$k]['fecha_inicio'].'</td>
								        <td>&nbsp;'.$actividades[$k]['fecha_termino'].'</td>
								        <td>&nbsp;</td>
								        <td>&nbsp;</td>
								        <td>&nbsp;';
    
			
	  $suma = ItemesActividades::model()->sumaMontoPorActividad($actividades[$k]['id']);
		
	  $montox='';
	  if(isset($suma)){
	        	$montox = $suma[0]['sumaMonto'];
	        	$totalMonto = $totalMonto+($suma[0]['sumaMonto']);
	  }
      $tablaDetallesAmi = $tablaDetallesAmi.$montox.'</td><td>&nbsp;</td>
        								<td>&nbsp;'.$d->r_implementacion.'</td></tr>';

      }//fin for 
      }else{
	
      $tablaDetallesAmi = $tablaDetallesAmi.'<tr><td colspan="8">&nbsp;No se encontraron registros de actividades</td></tr>';

      }
 
      $tablaDetallesAmi = $tablaDetallesAmi.'<tr><td colspan="5" bgcolor="#CCCCCC"><strong>Totales</strong></td>
        								<td>&nbsp;'.$totalMonto.'</td>
								        <td>&nbsp;</td>
								        <td>&nbsp;</td>
      									</tr>
    									</table>
    									</td>
  										</tr>
										</table>';
      
      $indice++;
     endforeach;
	
     /**
      * creando la tabla suma de los totales
      */
     
     $sumaTotales = $sumaTotales.'<table height="185" border="1" cellpadding="0" cellspacing="0" align="center">
		  							   <tr><td height="23" colspan="5" align="center" bgcolor="#CCCCCC"><strong>TOTAL DE PUNTAJES</strong></td></tr>
		  							   <tr><td bgcolor="#CCCCCC"><strong>Gobierno Regional</strong></td>
		    						   <td colspan="4">&nbsp;Gobierno Regional de Los Lagos</td></tr>
		  							   <tr><td bgcolor="#CCCCCC"><strong>Fecha</strong></td>
		    						   <td colspan="4">&nbsp;'.$_GET['fecha'].'</td></tr>
		  							   <tr><td bgcolor="#CCCCCC"><strong>Responsable</strong></td>
		    						   <td colspan="4">&nbsp;</td></tr>
		  							   <tr><td colspan="5">';

				$model = new LineasAccion('busquedaReporteAMILA');
				$datos = $model->busquedaReporteAMILA();

	$sumaTotales = $sumaTotales.'<table width="1100" border="1" cellpadding="0" cellspacing="0">
		      						  <tr><td  rowspan="2" align="center" bgcolor="#CCCCCC"><strong>AMI / Líneas de Aciión</strong></td>
		        					  <td  rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Elemento de Gestión</strong></td>
		        					  <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Puntaje</strong></td>
		        					  <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Delta Ponderado</strong></td>
		        					  <td rowspan="2" align="center" bgcolor="#CCCCCC"><strong>Fecha de Cumplimiento<strong></td></tr>
		      						  <tr><td align="center" bgcolor="#CCCCCC"><strong>Actual</strong></td>
		        					  <td align="center" bgcolor="#CCCCCC"><strong>Esperado</strong></td></tr>';
     
		     	$totalActual=0.0;
		     	$totalEsperado=0.0;
		     	$totalPonderado=0.0;
		     	$i=0;
		      	foreach($datos->getData() as $lineas): 
		      		
		      	$elementos = LaElemGestion::model()->elementosGestionPorAmi($lineas->id);

				        	for($k=0; $k<count($elementos); $k++){
				        		
					        		if($k==0){
					        		
					        		}else{
					        			
					        			if(($k+1)%3==0){
					  
					        			}else{

					        			}
					        		}
				        	}

				for($k=0; $k<count($elementos); $k++){
				        		
				if(!is_null($elementos[$k]['puntaje_actual'])){
					if($k==0){
					        	
					}else{
					        			
					if(($k+1)%3==0){
					        		
					 }else{
					        		
				}
					        			
				}
					        		
				$totalActual = $totalActual+$elementos[$k]['puntaje_actual'];
				}
				}

				for($k=0; $k<count($elementos); $k++){
				    if(!is_null($elementos[$k]['puntaje_esperado'])){
					     if($k==0){
				
					     }else{
					     if(($k+1)%3==0){
					        			
					      }else{
					        			
					      }
					}
					$totalEsperado = $totalEsperado+$elementos[$k]['puntaje_esperado'];
				    }
				 }

				 $resultado = 0.0;
				 for($k=0; $k<count($elementos); $k++){
				     $resultado = $resultado+($elementos[$k]['puntaje_esperado']-$elementos[$k]['puntaje_actual'])*$elementos[$k]['puntaje_elemento'];
				 }
				  
				 $totalPonderado = $totalPonderado+$resultado;

		        $i++;
		        endforeach;
	
	$sumaTotales = $sumaTotales.'<tr><td colspan="2" bgcolor="#CCCCCC"><strong>Totales:</strong></td>
					     		 <td>&nbsp;'.$totalActual.'</td>
					     		 <td>&nbsp;'.$totalEsperado.'</td>
					     		 <td>&nbsp;'.$totalPonderado.'</td>
					     		 <td>&nbsp;</td></tr></table></td></tr></table>';
	
	//junta todas las tablas hechas
	$datosImprimir = $mantenedorAMIS.'<br />'.$datosImprimir.$tablaDetallesLA.'<br />'.$mantenedorLA.'<br />'.$tablaDetallesAmi.'<br />'.	$tablaResumenAmi.'<br />'.$tablaResumenLA.'<br />'.$sumaTotales;
	
	//imprime el pdf
	if(isset($_GET['pdf'])){
			$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
			$mPDF1->WriteHTML($datosImprimir);
			$mPDF1->Output('ReporteAMILA.pdf','D');
	}
	//imprime el word
	if(isset($_GET['doc'])){
			Yii::app()->request->sendFile('ReporteAMILA.doc',$datosImprimir);		
	}
	
	
	
}//fin funcion reportes

}
?>