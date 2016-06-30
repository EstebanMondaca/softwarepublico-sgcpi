<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/FusionCharts.debug.js');
Yii::app()->clientScript->registerScript('init', "

		$( '#tabs' ).tabs();
		//Creando grafico RADAR del tabs 5
		var myChart = new FusionCharts($('#urlSitioWeb').val()+'/swf/Radar.swf','myChartId2', '890px', '350px', '0');
        myChart.setJSONData(".$dataProvider_tab5.");
        myChart.render('graficoRadarCriterios');
");
$totalActual = 0.0;
$totalRevisado = 0.0;
$totalMaximo = 0.0;
$totalGestion = 0.0;

//transformando el array a json

?>

<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Resumen General</a></li>

    <li><a href="#tabs-2">Detalles Criterio/Subcriterio</a></li>
    <li><a href="#tabs-3">Resumen Puntajes</a></li>
 	<li><a href="#tabs-4">Elementos de Gestión</a></li>
    <li><a href="#tabs-4_1">Gráfico Subcriterios</a></li>
    <li><a href="#tabs-5">Gráfico Radar</a></li>
  </ul>
  <div id="tabs-1">
  		<div style="float:right;" id='contenedoricono1' class='botoenesReportecdc'>
		<div style="float:left">Exportar a:&nbsp&nbsp&nbsp</div>
		<a id="linkExcel1"  name="linkExcel" title="Exportar a Pdf" href="<?php  echo Yii::app()->request->baseUrl.'/resumenGeneral/reportesTab1?pdf=1' ?>" >
		<div class="iconoPdf" id ="iconoPdf1" style="float:right"></div></a>
		<a id="linkExcel1"  name="linkExcel" title="Exportar a MS Word" href="<?php echo Yii::app()->request->baseUrl.'/resumenGeneral/reportesTab1?doc=1' ?>" >
		<div class="iconoWord" id ="iconoWord1" style="float:right"></div></a>
		</div>
		<br></br>
		
	<table  border="1" cellpadding="0" cellspacing="0" width="880" bordercolor="#4882AC">
	  <tr>
	    <td colspan="5" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>RESUMEN DE RESULTADO GENERAL</strong></center></td>
	  </tr>
	  <tr>
	    <td height="64" colspan="5">
	    <div style="max-height:600px;overflow:auto;height:auto;">
	    <!-- inicio tabla intermedia -->
	    <table width="878" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">
	      <tr>
	        <td width="288" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Categoría de Análisis</strong></center></td>
	        <td width="160" rowspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Puntaje Actual</strong></center></td>
	        <td colspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Niveles de Gestión según Puntaje</strong></center></td>
	        <td width="285" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Niveles de Gestión según Porcentaje de Logro</strong></center></td>
	        </tr>
	      <tr>
	        <td width="179" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Puntaje Validado</strong></center></td>
	        <td width="176" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Puntaje Máximo</strong></center></td>
	        <td bgcolor="#6095BD" class="textoReportesTablas"><center><strong>% Logro Validado</strong></center></td>
	        </tr>
	        <?php 
	        $i=0;
            $cantidadCriterios=0;
			foreach($arrayCalculoPRC as $key=>$value){
				$colorTr="#FBFBEF";
				if(($i+1)%2==1){
					$colorTr="#E5F1F4";
				}else{
					$colorTr="#FBFBEF";
				}

        			?>
        	      <tr bgcolor="<?php echo $colorTr; ?>">
        	        <td>&nbsp;<?php   echo $value['criterio_nom'];  ?></td>
        	        <td>&nbsp;
        	       	<?php 
        					echo round($value['actual'],1);
        					$totalActual = $totalActual+round($value['actual'],1);        				
        	       	?>
        	        </td>
        	        <td>&nbsp;
        	       	<?php
        	       	if($value['revisadoN']!='S.I.'){
        	       		echo round($value['revisadoN'],1);	       		
        					$totalRevisado = $totalRevisado+round($value['revisadoN'],1);
        			}else {
        				echo $value['revisadoN'];
        			}
        	       	 ?>
        	        </td>
        	        <td>&nbsp;
        	        <?php 
        	        if($value['maximo']!='S.I.'){
        	    		echo round($value['maximo2'],1);
        	    		
        	    			$totalMaximo = $totalMaximo+round($value['maximo2'],1);
        	    			
        	    	}else{
        
        				echo $value['maximo2'];
        			}
        	        ?>
        	        </td>
        	        <td>&nbsp;
        	        <?php
        	        if($value['porcentaje_final']!='S.I.'){
        				echo round($value['porcentaje_final'],1);
        				$totalGestion = $totalGestion+round($value['porcentaje_final'],1);
                        $cantidadCriterios++;
        			}else{
        
        				echo $value['porcentaje_final'];
        			}
        	     	?>
        	      </td>
        	        </tr>
        	        <?php
        	        $i++;
			}//fin for
	        ?>
	    </table>
	    </div>
	    <!-- fin tabla intermedia -->
	    </td>
	  </tr>
	  <tr >
	    <td width="289" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Puntaje Final</strong></center></td>
	    <td width="160">&nbsp;<?php echo round($totalActual,1); ?></td>
	    <td width="182">&nbsp;<?php echo round($totalRevisado,1); ?></td>
	    <td width="176">&nbsp;<?php echo round($totalMaximo,1); ?></td>
	    <td width="285">&nbsp;<?php 
	    if($cantidadCriterios>0){
	        echo round($totalGestion/$cantidadCriterios,1).'%'; 
	    }else{
	        echo '0%';
	    }
	    ?></td>
	  </tr>
	</table>

  </div>
  
  
  <div id="tabs-2">
	 	<div style="float:right;" id='contenedoricono' class='botoenesReportecdc'>
		<div style="float:left">Exportar a:&nbsp&nbsp&nbsp</div>
		<a id="linkExcel"  name="linkExcel" title="Exportar a Pdf" href="<?php  echo Yii::app()->request->baseUrl.'/resumenGeneral/ReporteTab2?pdf=1' ?>" >
		<div class="iconoPdf" id ="iconoPdf" style="float:right"></div></a>
		<a id="linkExcel"  name="linkExcel" title="Exportar a MS Word" href="<?php echo Yii::app()->request->baseUrl.'/resumenGeneral/ReporteTab2?doc=1' ?>" >
		<div class="iconoWord" id ="iconoWord" style="float:right"></div></a>
		</div>
		<br></br>

  	   <div  style="float: left">Criterio: &nbsp;&nbsp;&nbsp;
		<?php 
				//combobox de divisiones
				echo CHtml::dropDownList(
				'criterio2',""
				,array('0'=>'Seleccione Criterio')+CHtml::listData(Criterios::model()->findAll(array('condition'=>'estado = 1')),'id','nombre')
				,array('id'=>'criterio2', 'onchange'=>'js:mostrarResumenGeneralPorCriterio(this.value);','class'=>'selectorIndicadores')
				);
		?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
		<br />
		<br />
		<div id="grillaDatosResumenCriterio" style="display:none">
		
		<?php 
	
		$this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'items-gridS',
				'dataProvider' => $dataProvider_tab3,
				'summaryText' => false,
				'enablePagination' => true,
				'afterAjaxUpdate'=>'function(){afterAjaxUpdateSuccess();mostrarBoton();}',
				'columns' => array(		
						array('header'=>'Nº',
								'htmlOptions'=>array('width'=>'30'),
								'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
						),
						array(
								'name'=>'nombre',
								'header'=>'Sub Criterio'
						),
						array(
								'name'=>'logro',
								'header'=>'% Logro'
						),
						array(
								'name'=>'revisado',
								'header'=>'Puntaje SubCriterio'
						),
						array(
								'name'=>'actual',
								'header'=>'Puntaje Actual'
						),					
				),
		));		
		
		?>
		
		</div>

  </div>
 <div id="tabs-3">
  		<div style="float:right;" id='contenedoricono' class='botoenesReportecdc'>
		<div style="float:left">Exportar a:&nbsp&nbsp&nbsp</div>
		<a id="linkExcel"  name="linkExcel" title="Exportar a Pdf" href="<?php  echo Yii::app()->request->baseUrl.'/resumenGeneral/ReporteTab3?pdf=1' ?>" >
		<div class="iconoPdf" id ="iconoPdf" style="float:right"></div></a>
		<a id="linkExcel"  name="linkExcel" title="Exportar a MS Word" href="<?php echo Yii::app()->request->baseUrl.'/resumenGeneral/ReporteTab3?doc=1' ?>" >
		<div class="iconoWord" id ="iconoWord" style="float:right"></div></a>
		</div>
		<br></br>

    <div  style="float: left">Criterio: &nbsp;&nbsp;&nbsp;
	<?php 
			//combobox de divisiones
			echo CHtml::dropDownList(
			'criterio',""
			,array('0'=>'Seleccione Criterio')+CHtml::listData(Criterios::model()->findAll(array('condition'=>'estado = 1')),'id','nombre')
			,array('id'=>'criterio', 'onchange'=>'js:mostrarSubCriteriosResumenGeneral(this.value, "subCriterio");','class'=>'selectorIndicadores')
			);
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</div>

<div>Sub Criterio: &nbsp;&nbsp;&nbsp;
<?php 

		//combobox centros costos
		echo CHtml::dropDownList(
		'subCriterio',""
		,array('0'=>'Seleccione Sub Criterio')
		,array('id'=>'subCriterio','onchange'=>'js:mostrarElementosPorSubcriterio(this.value);', 'class'=>'selectorIndicadores')
		);


//inicio grilla de datos
?>
</div>
<div id="grillaDatosResumen" style="display:none">
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'items-grid',
		'dataProvider' => $dataProvider,
		'summaryText' => false,
		'enablePagination' => true,
		'afterAjaxUpdate'=>'function(){afterAjaxUpdateSuccess();mostrarBoton();}',
		'columns' => array(

				array('header'=>'Nº',
						'htmlOptions'=>array('width'=>'30'),
						'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
				),
				array(
						'name'=>'nombre',
						'header'=>'Elemento de Gestión'
				),
				array(
						'name'=>'puntaje',
						'header'=>'Puntaje Validado',
						'type'=>'raw',
						'value'=>array(LaElemGestion::model(), 'puntajeRevisadoPorElemento'),
				),
				array(
						'name'=>'puntaje',
						'header'=>'Puntaje Actual',
						'type'=>'raw',
						'value'=>array(ElementosGestionResponsable::model(), 'getPuntajeActual'),
				),
		),
));

?>
</div>
		

  </div>

  
<div id="tabs-4">
  		<div style="float:right;" id='contenedoricono' class='botoenesReportecdc'>
		<div style="float:left">Exportar a:&nbsp&nbsp&nbsp</div>
		<a id="linkExcel"  name="linkExcel" title="Exportar a Pdf" href="<?php  echo Yii::app()->request->baseUrl.'/resumenGeneral/reporteTab4?pdf=1' ?>" >
		<div class="iconoPdf" id ="iconoPdf" style="float:right"></div></a>
		<a id="linkExcel"  name="linkExcel" title="Exportar a MS Word" href="<?php echo Yii::app()->request->baseUrl.'/resumenGeneral/reporteTab4?doc=1' ?>" >
		<div class="iconoWord" id ="iconoWord" style="float:right"></div></a>
		</div>
		<br></br>

<table border="0" cellpadding="1" cellspacing="1">
<tbody>
<tr>
<td>
&nbsp;&nbsp;Criterio:&nbsp;
<?php 
			//combobox de divisiones
			echo CHtml::dropDownList(
			'criterioE',""
			,array('0'=>'Seleccione Criterio')+CHtml::listData(Criterios::model()->findAll(array('condition'=>'estado = 1')),'id','nombre')
			,array('id'=>'criterioE', 'onchange'=>'js:mostrarSubCriteriosResumenGeneral(this.value, "subCriterioE");','class'=>'selectorIndicadores')
			);
?>
</td>
<td>
&nbsp;&nbsp;Sub Criterio:&nbsp;
<?php 

		//combobox centros costos
		echo CHtml::dropDownList(
		'subCriterioE',""
		,array('0'=>'Seleccione Sub Criterio')
		,array('id'=>'subCriterioE','onchange'=>'js:elementosGestionSubResumenGeneral(this.value);', 'class'=>'selectorIndicadores')
		);


//inicio grilla de datos
?>

</td>
<td>
&nbsp;&nbsp;E. Gestión:&nbsp;
<?php 

		//combobox centros costos
		echo CHtml::dropDownList(
		'elementoS',""
		,array('0'=>'Seleccione Elemento de Gestión')
		,array('id'=>'elementoS','onchange'=>'js:mostrarElementosResumenGeneral(this.value);', 'class'=>'selectorIndicadores')
		);


//inicio grilla de datos
?>
</td>
</tr>
</tbody>
</table>
<br/>
<div id="grillaElementosResumen" style="display:none">
<!-- inicio tabla -->
<table width="806" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2">&nbsp; 
    
    <!-- inicio div criterio -->
    	<div class="fieldset2">
            <div class="legend">Criterio</div>                    
               <div id="contenido"></div>
        </div>
    <!-- fin div criterio -->
    
    </td>
  </tr>
  <tr>
    <td>&nbsp;
    
    <!-- inicio div subcriterio -->
   	  <div class="fieldset2">
            <div class="legend">SubCriterio</div> 
               <div id = "contenido2" style="height:63px;overflow: auto;width: 232px;">                   
                        
            </div>
       </div>
     <!-- fin div subcriterio -->  
     
    </td>
    <td>&nbsp;&nbsp;&nbsp;
    
    <!-- inicio tabla puntajes -->
     <table class="evidencia" width="100%" border="1" cellspacing="0" cellpadding="0">
                       <thead> 
                      <tr align="center">
                        <th width="18%">No Hay despliegue</th>
                        <th colspan="2">Despliegue parcial</th>
                        <th colspan="3">Despliegue total</th>
                      </tr>
                      </thead>
                      <tbody>
                          <tr align="center" class='even'>
                            <td>No Hay enfoque</td>
                            <td width="16%">Enfoque incipiente </td>
                            <td width="16%">Enfoque sistematico</td>
                            <td width="16%">Enfoque evaluado</td>
                            <td width="16%">Enfoque mejorado</td>
                            <td >Enfoque efectivo</td>
                          </tr>
                          <tr align="center" id ="des">
                            <td id="despliegue0">0</td>
                            <td id="despliegue1">1</td>
                            <td id="despliegue2">2</td>
                            <td id="despliegue3">3</td>
                            <td id="despliegue4">4</td>
                            <td id="despliegue5">5</td>
                          </tr>
                      </tbody>
      </table>
    <!-- fin tabla puntajes -->
    
    </td>
  </tr>
  <tr>
    <td>&nbsp;
    
    <!-- inicio div elemento gestion -->
   		<div class="fieldset2" style='height: 196px;'>
           <div class="legend">E. Gestión</div>                    
               <div id ="contenido3" style="height:169px;overflow: auto;width: 232px;">
                       
               </div>
        </div> 
    <!-- fin div elemento gestion -->
    
    </td>
    <td>&nbsp;
    
    <!-- inicio div evidencia -->
     <div id="laElemGestions_evidencia" class="fieldset2" style="height: 196px;">
              <div class="legend">Evidencia</div> 
              	<div id ="contenido4" style="overflow: auto; height: 190px;"></div> 
         
              <div id="mensajeEvidencia" class="errorMessage" style="display:none">Evidencia no puede ser nulo.</div>
      </div> 
    <!-- fin div evidencia -->
    
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
    
    <!-- aqui archivo -->
    <div id="laElemGestions_archivo" class="fieldset2">
         <div class="legend">Documento con Evidencia de Avance</div>
         	<div id="linkA"></div>
    </div>
    
    <!-- fin archivo -->
    
    </td>
  </tr>
</table>
<!-- fin tabla -->

</div>

</div><!-- fin ultimo tab -->

  <div id="tabs-4_1">
      <div  style="float: left">Criterio: &nbsp;&nbsp;&nbsp;
        <?php 
                //combobox de divisiones
                echo CHtml::dropDownList(
                'criterio2',""
                ,array('0'=>'Seleccione Criterio')+CHtml::listData(Criterios::model()->findAll(array('condition'=>'estado = 1')),'id','nombre')
                ,array('id'=>'criterio_grafico1', 'onchange'=>'js:mostrarGraficoPorCriterio(this.value);','class'=>'selectorIndicadores')
                );
        ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="limpia"></div>
        <div id="graficoBarraPorCriterio" style="height: 350px; margin: auto;  width: 600px;">
            
        </div>
  </div>
  <div id="tabs-5">
      
        <div id="graficoRadarCriterios" style="height: 450px; margin: auto;  width: 890px;">
            
            
        </div>
    
  </div>
</div><!-- fin todos los tabs -->

