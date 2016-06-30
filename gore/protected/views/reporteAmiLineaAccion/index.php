<?php
Yii::app()->clientScript->registerScript('init', "

		$( '#tabs' ).tabs();
");	

$this->breadcrumbs = array(
		Yii::t('ui','Reportes')=>array('/reportes'),
		'Plan de Mejora',
);

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
?>

<div style="float:right;" id='contenedoricono' class='botoenesReportecdc'>
<div style="float:left">Exportar a:&nbsp&nbsp&nbsp</div>
<a id="linkExcel"  name="linkExcel" title="Exportar a Pdf" href="<?php  echo Yii::app()->request->baseUrl.'/reporteAmiLineaAccion/reportes?pdf=1&fecha='.$fecha; ?>" >
<div class="iconoPdf" id ="iconoPdf" style="float:right"></div></a>
<a id="linkExcel"  name="linkExcel" title="Exportar a MS Word" href="<?php echo Yii::app()->request->baseUrl.'/reporteAmiLineaAccion/reportes?doc=1&fecha='.$fecha; ?>" >
<div class="iconoWord" id ="iconoWord" style="float:right"></div></a>
</div>
<br></br>
<!--  INICIO PRIMER TAB -->

<div id="tabs">
  <ul>
    <li><a href="#tabs-1">AMI</a></li>
    <li><a href="#tabs-2">Líneas de Acción</a></li>
    <li><a href="#tabs-3">Síntesis AMI</a></li>
    <li><a href="#tabs-4">Síntesis Líneas de Acción</a></li>
    <li><a href="#tabs-5">Total</a></li>
  </ul>
  <div id="tabs-1">

	<?php 
	
		$this->widget('zii.widgets.grid.CGridView', array(
		    'dataProvider'=>LineasAccion::model()->busquedaAmiReporte(0),
			'afterAjaxUpdate'=>'function(id, data){parent.afterAjaxUpdateSuccess();}',
			'summaryText'=>'',
			//'selectableRows'=>1,
		//	'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('update').'/id/"+$.fn.yiiGridView.getSelection(id);}',
			'columns'=>array(
			array(          
	            'name'=>'nombre',
				'header'=>'Nombre de la AMI',
       		 ),
       		 array(
				'name'=>'criteriosc',
				'header'=>'Criterios(s) Subcriterio(s)',
       		 	'type'=>'raw',
				'value'=>array(LaElemGestion::model(), 'obtieneCriteriosPorElementosGestionAmi'),
			),
			array(          
	            'name'=>'r_implementacion',
				'header'=>'Responsable Implementación',
       		 ),
       		 array(          
	            'name'=>'r_mantencion',
				'header'=>'Responsable Mantención',
       		 ),
       			
			array(          
	            'name'=>'r_implementacion',
				'header'=>'Plazo de Ejecución',
				'value'=>''
       		 ),
       		 array(
				'name'=>'resultado',
				'header'=>'Delta p Ponderado',
       		 	'type'=>'raw',
				'value'=>array(LaElemGestion::model(), 'obtienePonderacionPorElementosGestionAmi'),
			),
			
			array
			(
		    'class'=>'CButtonColumn',
		    'template'=>'{update}',
			
		    'buttons'=>array
		    (
		       'update' => array
		        (
		            'label'=>'Detalles', 
		            'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
		            'url'=>'$this->grid->controller->createUrl("update", array("id"=>$data["id"]))',
		        	
		        ),
		    ),
		),
					
	
		),
		));
			
	?>

  </div>
  
  <!-- INICIO SEGUNDO TAB    -->
  
  <div id="tabs-2">
  <?php 
  
  		$this->widget('zii.widgets.grid.CGridView', array(
    	'dataProvider'=>LineasAccion::model()->busquedaAmiReporte(1),
  		'summaryText'=>'',
  		'columns'=>array(
  			array(
				'name'=>'criteriosc',
				'header'=>'Área de Mejora',
       		 	'type'=>'raw',
				'value'=>array(LaElemGestion::model(), 'obtieneCriteriosPorElementosGestionAmi'),
			),
		
       		 array(          
	            'name'=>'r_implementacion',
				'header'=>'Responsable',
       		 ),
       	
       		 array(          
	            'name'=>'nombre',
				'header'=>'Línea de Acción',
       		 ),
							array
			(
		    'class'=>'CButtonColumn',
		    'template'=>'{viewla}',
			
		    'buttons'=>array
		    (
		       'viewla' => array
		        (
		            'label'=>'Detalles', 
		        	'options'=>array('class'=>'update'),
		            'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
		            'url'=>'$this->grid->controller->createUrl("viewla", array("id"=>$data["id"]))',
		        	
		        ),
		    ),
		),
       	),
	));
  
  ?>

  </div>
  <div id="tabs-3">
		<table width="800" height="185" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
		  <tr bgcolor="#FBFBEF">
		    <td height="23" colspan="5" align="center" bgcolor="#6095BD" class="textoReportesTablas">SÍNTESIS DE AMI </td>
		  </tr>
		  <tr bgcolor="#E5F1F4">
		    <td width="238" bgcolor="#6095BD" class="textoReportesTablas">Gobierno Regional</td>
		    <td width="509" colspan="4">&nbsp;Gobierno Regional de Los Lagos</td>
		  </tr>
		  <tr bgcolor="#FBFBEF">
		    <td bgcolor="#6095BD" class="textoReportesTablas">Fecha</td>
		    <td colspan="4">&nbsp;<?php echo $fecha; ?></td>
		  </tr>
		  <tr bgcolor="#E5F1F4">
		    <td bgcolor="#6095BD" class="textoReportesTablas">Responsable</td>
		    <td colspan="4">&nbsp;</td>
		  </tr>
		  <tr>
		    <td colspan="5">
		
			<!-- inicio tabla -->
			
			<?php 
				$model = new LineasAccion('busquedaReporteAMILA');
				$model->id_tipo_la=1;
				$datos = $model->busquedaReporteAMILA();
				
			?>
			<div style="max-height:600px;overflow:auto;height:auto;">
		    <table width="852" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
		      <tr>
		        <td width="178" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">AMI / Líneas de Aciión</strong></td>
		        <td width="100" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Elemento de Gestión</td>
		        <td colspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Puntaje</td>
		        <td width="169" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Delta Ponderado</td>
		        <td width="159" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Fecha de Cumplimiento</td>
		        </tr>
		      <tr>
		        <td width="136" align="center" bgcolor="#6095BD" class="textoReportesTablas">Actual</td>
		        <td width="137" align="center" bgcolor="#6095BD" class="textoReportesTablas">Esperado</td>
		      </tr>
		      <?php       
		     	$totalActual=0.0;
		     	$totalEsperado=0.0;
		     	$totalPonderado=0.0;
		     	$i=0;
		      	foreach($datos->getData() as $lineas): 
		      	
		      			$colorTr="#FBFBEF";
						if(($i+1)%2==1){
							$colorTr="#E5F1F4";
						}else{
							$colorTr="#FBFBEF";
						}
		      	//los elementos de gestion no depende del periodo	
		      	$elementos = LaElemGestion::model()->elementosGestionPorAmi($lineas->id);
		      ?>
		     		 <tr  bgcolor="<?php echo $colorTr; ?>">
				        <td>&nbsp;<?php echo $lineas->nombre; ?></td>
				        <td>&nbsp;
				        <?php 
				        	for($k=0; $k<count($elementos); $k++){
				        		
				        		//if(isset($elementos[$k]['n_criterios'])&&isset($elementos[$k]['n_subcriterios'])&&isset($elementos[$k]['n_elementos'])){
					        		if($k==0){
					        			echo $elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        		}else{
					        			
					        			if(($k+1)%3==0){
					        				echo ';<br/>&nbsp;&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        			}else{
					        				echo ';&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        			}
					        		}
				        		
				        	}
				        ?>
				       
				        </td>
				        <td>&nbsp;
				         <?php 
				        	for($k=0; $k<count($elementos); $k++){
				        		
				        		if(!is_null($elementos[$k]['puntaje_actual'])){
					        		if($k==0){
					        			echo $elementos[$k]['puntaje_actual'];
					        		}else{
					        			
					        			if(($k+1)%3==0){
					        				echo  ';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}else{
					        				echo  ';&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}
					        			
					        		}
					        		
					        		$totalActual = $totalActual+$elementos[$k]['puntaje_actual'];
				        		}
				        	}
				        ?>
				        </td>
				        <td>&nbsp;
				        <?php 
				        	for($k=0; $k<count($elementos); $k++){
				        		if(!is_null($elementos[$k]['puntaje_esperado'])){
					        		if($k==0){
					        			echo $elementos[$k]['puntaje_esperado'];
					        		}else{
					        			if(($k+1)%3==0){
					        				echo  ';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_esperado'];
					        			}else{
					        				echo  ';&nbsp;'.$elementos[$k]['puntaje_esperado'];
					        			}
					        		}
					        		$totalEsperado = $totalEsperado+$elementos[$k]['puntaje_esperado'];
				        		}
				        	}
				        ?>
				        </td>
				        <td>&nbsp;
				         <?php 
				         	$resultado = 0.0;
				        	for($k=0; $k<count($elementos); $k++){
				        		$resultado = $resultado+($elementos[$k]['puntaje_esperado']-$elementos[$k]['puntaje_actual'])*$elementos[$k]['puntaje_elemento'];
				        		
				        	}
				        	echo $resultado;
				        	$totalPonderado = $totalPonderado+$resultado;
				        ?>
				        </td>
				        <td>&nbsp;</td>
		      		  </tr>
		
		        <?php
		        $i++;
		        endforeach; ?>
		           <tr bgcolor="#FBFBEF">
		     		   <td colspan="2" bgcolor="#6095BD" class="textoReportesTablas">Totales:</td>
		     		   <td>&nbsp;<?php echo $totalActual; ?></td>
		     		   <td>&nbsp;<?php echo $totalEsperado; ?></td>
		     		   <td>&nbsp;<?php echo $totalPonderado; ?></td>
		     		   <td bgcolor="#6095BD">&nbsp;</td>
		   		 </tr>
		    </table>
		    </div>
		    <!-- fin tabla intermedia -->
		    </td>
		  </tr>
		</table>
</div>
<div id="tabs-4">

		<table width="800" height="185" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
		  <tr bgcolor="#FBFBEF">
		    <td height="23" colspan="5" align="center" bgcolor="#6095BD" class="textoReportesTablas">SÍNTESIS DE LÍNEA DE ACCIÓN </td>
		  </tr>
		  <tr bgcolor="#E5F1F4">
		    <td width="238" bgcolor="#6095BD" class="textoReportesTablas">Gobierno Regional</td>
		    <td width="509" colspan="4">&nbsp;Gobierno Regional de Los Lagos</td>
		  </tr>
		  <tr bgcolor="#FBFBEF">
		    <td bgcolor="#6095BD" class="textoReportesTablas">Fecha</td>
		    <td colspan="4">&nbsp;<?php echo $fecha; ?></td>
		  </tr>
		  <tr bgcolor="#E5F1F4">
		    <td bgcolor="#6095BD" class="textoReportesTablas">Responsable</td>
		    <td colspan="4">&nbsp;</td>
		  </tr>
		  <tr>
		    <td colspan="5">
		
			<!-- inicio tabla -->
			
			<?php 
				$model = new LineasAccion('busquedaReporteAMILA');
				$model->id_tipo_la=2;
				$datos = $model->busquedaReporteAMILA();
			
				
			?>
			<div style="max-height:600px;overflow:auto;height:auto;">
		    <table width="852" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
		      <tr>
		        <td width="178" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">AMI / Líneas de Aciión</strong></td>
		        <td width="100" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Elemento de Gestión</td>
		        <td colspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Puntaje</td>
		        <td width="169" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Delta Ponderado</td>
		        <td width="159" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Fecha de Cumplimiento</td>
		        </tr>
		      <tr>
		        <td width="136" align="center" bgcolor="#6095BD" class="textoReportesTablas">Actual</td>
		        <td width="137" align="center" bgcolor="#6095BD" class="textoReportesTablas">Esperado</td>
		      </tr>
		      <?php       
		     	$totalActual=0.0;
		     	$totalEsperado=0.0;
		     	$totalPonderado=0.0;
		     	$i=0;
		      	foreach($datos->getData() as $lineas): 
		      	
		      			$colorTr="#FBFBEF";
						if(($i+1)%2==1){
							$colorTr="#E5F1F4";
						}else{
							$colorTr="#FBFBEF";
						}
		      		
		      	$elementos = LaElemGestion::model()->elementosGestionPorAmi($lineas->id);
		      ?>
		     		 <tr  bgcolor="<?php echo $colorTr; ?>">
				        <td>&nbsp;<?php echo $lineas->nombre; ?></td>
				        <td>&nbsp;
				        <?php 
				        	for($k=0; $k<count($elementos); $k++){
				        		
				        		//if(isset($elementos[$k]['n_criterios'])&&isset($elementos[$k]['n_subcriterios'])&&isset($elementos[$k]['n_elementos'])){
					        		if($k==0){
					        			echo $elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        		}else{
					        			
					        			if(($k+1)%3==0){
					        				echo ';<br/>&nbsp;&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        			}else{
					        				echo ';&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        			}
					        		}
				        		
				        	}
				        ?>
				       
				        </td>
				        <td>&nbsp;
				         <?php 
				        	for($k=0; $k<count($elementos); $k++){
				        		
				        		if(!is_null($elementos[$k]['puntaje_actual'])){
					        		if($k==0){
					        			echo $elementos[$k]['puntaje_actual'];
					        		}else{
					        			
					        			if(($k+1)%3==0){
					        				echo  ';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}else{
					        				echo  ';&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}
					        			
					        		}
					        		
					        		$totalActual = $totalActual+$elementos[$k]['puntaje_actual'];
				        		}
				        	}
				        ?>
				        </td>
				        <td>&nbsp;
				        <?php 
				        	for($k=0; $k<count($elementos); $k++){
				        		if(!is_null($elementos[$k]['puntaje_esperado'])){
					        		if($k==0){
					        			echo $elementos[$k]['puntaje_esperado'];
					        		}else{
					        			if(($k+1)%3==0){
					        				echo  ';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_esperado'];
					        			}else{
					        				echo  ';&nbsp;'.$elementos[$k]['puntaje_esperado'];
					        			}
					        		}
					        		$totalEsperado = $totalEsperado+$elementos[$k]['puntaje_esperado'];
				        		}
				        	}
				        ?>
				        </td>
				        <td>&nbsp;
				         <?php 
				         	$resultado = 0.0;
				        	for($k=0; $k<count($elementos); $k++){
				        		$resultado = $resultado+(($elementos[$k]['puntaje_esperado']-$elementos[$k]['puntaje_actual'])*$elementos[$k]['puntaje_elemento']);
				        		
				        	}
				        	echo $resultado;
				        	$totalPonderado = $totalPonderado+$resultado;
				        ?>
				        </td>
				        <td>&nbsp;</td>
		      		  </tr>
		
		        <?php
		        $i++;
		        endforeach; ?>
		           <tr bgcolor="#FBFBEF">
		     		   <td colspan="2" bgcolor="#6095BD" class="textoReportesTablas">Totales:</td>
		     		   <td>&nbsp;<?php echo $totalActual; ?></td>
		     		   <td>&nbsp;<?php echo $totalEsperado; ?></td>
		     		   <td>&nbsp;<?php echo $totalPonderado; ?></td>
		     		   <td bgcolor="#6095BD">&nbsp;</td>
		   		 </tr>
		    </table>
		    </div>
		    <!-- fin tabla intermedia -->
		    </td>
		  </tr>
		</table>
</div>
<div id="tabs-5">
		<table width="800" height="185" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
		  <tr bgcolor="#FBFBEF">
		    <td height="23" colspan="5" align="center" bgcolor="#6095BD" class="textoReportesTablas">TOTAL DE PUNTAJES </td>
		  </tr>
		  <tr bgcolor="#E5F1F4">
		    <td width="238" bgcolor="#6095BD" class="textoReportesTablas">Gobierno Regional</td>
		    <td width="509" colspan="4">&nbsp;Gobierno Regional de Los Lagos</td>
		  </tr>
		  <tr bgcolor="#FBFBEF">
		    <td bgcolor="#6095BD" class="textoReportesTablas">Fecha</td>
		    <td colspan="4">&nbsp;<?php echo $fecha; ?></td>
		  </tr>
		  <tr bgcolor="#E5F1F4">
		    <td bgcolor="#6095BD" class="textoReportesTablas">Responsable</td>
		    <td colspan="4">&nbsp;</td>
		  </tr>
		  <tr>
		    <td colspan="5">
		
			<!-- inicio tabla -->
			
			<?php 
				$model = new LineasAccion('busquedaReporteAMILA');
				$datos = $model->busquedaReporteAMILA();
			
				
			?>
			<div style="max-height:600px;overflow:auto;height:auto;">
		    <table width="852" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
		      <tr>
		        <td width="178" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">AMI / Líneas de Aciión</strong></td>
		        <td width="100" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Elemento de Gestión</td>
		        <td colspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Puntaje</td>
		        <td width="169" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Delta Ponderado</td>
		        <td width="159" rowspan="2" align="center" bgcolor="#6095BD" class="textoReportesTablas">Fecha de Cumplimiento</td>
		        </tr>
		      <tr>
		        <td width="136" align="center" bgcolor="#6095BD" class="textoReportesTablas">Actual</td>
		        <td width="137" align="center" bgcolor="#6095BD" class="textoReportesTablas">Esperado</td>
		      </tr>
		      <?php       
		     	$totalActual=0.0;
		     	$totalEsperado=0.0;
		     	$totalPonderado=0.0;
		     	$i=0;
		      	foreach($datos->getData() as $lineas): 
		      	
		      			$colorTr="#FBFBEF";
						if(($i+1)%2==1){
							$colorTr="#E5F1F4";
						}else{
							$colorTr="#FBFBEF";
						}
		      		
		      	$elementos = LaElemGestion::model()->elementosGestionPorAmi($lineas->id);
		      ?>
		     		
				        <?php 
				        	for($k=0; $k<count($elementos); $k++){
				        		
				        		//if(isset($elementos[$k]['n_criterios'])&&isset($elementos[$k]['n_subcriterios'])&&isset($elementos[$k]['n_elementos'])){
					        		if($k==0){
					        		//	echo $elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        		}else{
					        			
					        			if(($k+1)%3==0){
					        			//	echo ';<br/>&nbsp;&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        			}else{
					        				//echo ';&nbsp;'.$elementos[$k]['n_criterios'].'.'.$elementos[$k]['n_subcriterios'].'.'.$elementos[$k]['n_elementos'];
					        			}
					        		}
				        		
				        	}
				        ?>
				       
				   
				         <?php 
				        	for($k=0; $k<count($elementos); $k++){
				        		
				        		if(!is_null($elementos[$k]['puntaje_actual'])){
					        		if($k==0){
					        			//echo $elementos[$k]['puntaje_actual'];
					        		}else{
					        			
					        			if(($k+1)%3==0){
					        				//echo  ';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}else{
					        				//echo  ';&nbsp;'.$elementos[$k]['puntaje_actual'];
					        			}
					        			
					        		}
					        		
					        		$totalActual = $totalActual+$elementos[$k]['puntaje_actual'];
				        		}
				        	}
				        ?>
				  
				        <?php 
				        	for($k=0; $k<count($elementos); $k++){
				        		if(!is_null($elementos[$k]['puntaje_esperado'])){
					        		if($k==0){
					        			//echo $elementos[$k]['puntaje_esperado'];
					        		}else{
					        			if(($k+1)%3==0){
					        				//echo  ';<br/>&nbsp;&nbsp;'.$elementos[$k]['puntaje_esperado'];
					        			}else{
					        				//echo  ';&nbsp;'.$elementos[$k]['puntaje_esperado'];
					        			}
					        		}
					        		$totalEsperado = $totalEsperado+$elementos[$k]['puntaje_esperado'];
				        		}
				        	}
				        ?>
				   
				         <?php 
				         	$resultado = 0.0;
				        	for($k=0; $k<count($elementos); $k++){
				        		$resultado = $resultado+($elementos[$k]['puntaje_esperado']-$elementos[$k]['puntaje_actual'])*$elementos[$k]['puntaje_elemento'];
				        		
				        	}
				        	//echo $resultado;
				        	$totalPonderado = $totalPonderado+$resultado;
				        ?>
			
		
		        <?php
		        $i++;
		        endforeach; ?>
		           <tr bgcolor="#FBFBEF">
		     		   <td colspan="2" bgcolor="#6095BD" class="textoReportesTablas">Totales:</td>
		     		   <td>&nbsp;<?php echo $totalActual; ?></td>
		     		   <td>&nbsp;<?php echo $totalEsperado; ?></td>
		     		   <td>&nbsp;<?php echo $totalPonderado; ?></td>
		     		   <td bgcolor="#6095BD">&nbsp;</td>
		   		 </tr>
		    </table>
		    </div>
		    <!-- fin tabla intermedia -->
		    </td>
		  </tr>
		</table>
</div>
</div>