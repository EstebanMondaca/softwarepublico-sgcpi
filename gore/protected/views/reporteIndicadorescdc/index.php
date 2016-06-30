<?php 
Yii::app()->clientScript->registerScript('init', "

		$( '#tabs' ).tabs();

	

");	

Yii::app()->clientScript->registerScript('creationComplete', "

	var bandera = $('#banderaDiv').attr('validarVacio');	
	if(parseInt(bandera) != parseInt(0)){//son todos vacios
		$('#contenedoricono').show('slow');	
	}else{	
		$('#contenedoricono').hide('slow');
	}
	



");	

$divisiones = $model->getData();
?>
	
<div style="float:right;" id='contenedoricono' class='botoenesReportecdc'>
<div style="float:left">Exportar a:&nbsp&nbsp&nbsp</div>
<a id="linkExcel"  name="linkExcel" title="Exportar a Pdf" href="<?php  echo Yii::app()->request->baseUrl.'/reporteIndicadorescdc/reportes?idDivision=0&pdf'; ?>" >
<div class="iconoPdf" id ="iconoPdf" style="float:right"></div></a>
<a id="linkExcel"  name="linkExcel" title="Exportar a MS Word" href="<?php echo Yii::app()->request->baseUrl.'/reporteIndicadorescdc/reportes?idDivision=0&doc'; ?>" >
<div class="iconoWord" id ="iconoWord" style="float:right"></div></a>
</div>
<br></br>
<div id="tabs">
  <ul>
<?php 
//creando cabeceras de tab
for($i=0; $i<count($divisiones); $i++){
?>
 <li><a href="<?php echo '#tabs-'.$i; ?>"><?php echo $divisiones[$i]['nombre']; ?></a></li>
<?php }?>
</ul>

<?php
//creando tabs 
$validarVacios=0;
for($j=0; $j<count($divisiones); $j++){
	
?>

 
  <div id="<?php echo 'tabs-'.$j; ?>">
  	<?php   		
  	$id = $divisiones[$j]['id'];
 
  	$indi= LineasAccion::model()->busquedaPersonalizadaReportecdc($id);

  		if(!empty($indi)){
  			$validarVacios++;
			$c = new ConsultasView();
				for ($i=0; $i<count($indi);$i++){
						
					$auxiliar=array();
					$c = new ConsultasView();
					
					if(!empty($indi[$i]['idIndicador']['id'])){
					
						
						$auxiliar = $c->construyendoBarras($indi[$i]['idIndicador']['id'],$indi[$i]['idIndicador']['frecuenciaControl']['plazo_maximo']);
					
						 if($auxiliar['value'] != -1 && $auxiliar['value']>=0){
						 	$indi[$i]['value'] = $auxiliar['value'];
						 }else{
						 	$indi[$i]['value'] = 'S.I.';
						 }
		
					}//fin if si no vienen parametros vacios
					else{
					
						$indi[$i]['value'] = 'S.I.';
		
					}
					if($indi[$i]['value']!='S.I.'&&!empty($indi[$i]['idIndicador']['meta_anual'])){
						
						if($indi[$i]['idIndicador']['meta_anual']!=0){
							$indi[$i]['cumplimiento']  = ($indi[$i]['value']*100)/$indi[$i]['idIndicador']['meta_anual'];
						}else{
							$indi[$i]['cumplimiento']  = ($indi[$i]['value']*100)/1;
						}
						if($indi[$i]['cumplimiento']>=100){
							$indi[$i]['cumple']  = 'SI';
						}else{
							$indi[$i]['cumple']  = 'NO';
						}
				
					}else{
						
						$indi[$i]['cumplimiento'] = 'S.I.';
						
						$indi[$i]['cumple']  = 'S.I.';
					}

				}//fin for
	}//fin if

		


		$dataProvider = new CArrayDataProvider($indi, 
		array(
			   'keyField' => 'id',         
			   'id' => 'data', 
			    'pagination'=>array(
			        'pageSize'=>7,
			    ),                   
			)
			
		);
		

	$this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider'=>$dataProvider,
		'id'=>'items-grid'.$j,
		'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();mostrarBoton();}',
		'columns'=>array(
			array(          
	            'name'=>'id_indicador',
				'header'=>'id indicador',
				'htmlOptions'=>array("style"=>"display:none"),
				'headerHtmlOptions'=>array("style"=>"display:none"),
	     
       		 ),
			array(          
	            'name'=>'nombre',
				'header'=>'Linea Acción',
	           
       		 ),
			array(            
	            'name'=>'indicador',
				'header'=>'Indicadores de evaluación',
	   
       		 ),
       		array(           
	            'name'=>'meta_anual',
       		    'header'=>'Meta',
	          
       		),
       		array(           
	            'name'=>'cumplimiento',
       		    'header'=>'% Cumplimiento',
	          
       		),
       		array(           
	            'name'=>'value',
       		    'header'=>'Efectivo',
	          
       		),
       		array(           
	            'name'=>'cumple',
       		    'header'=>'Cumple',
	          
       		),
       		array(
				'name'=>'ponderacion',
				'header'=>'Ponderación',
				'value'=>array(Instrumentos::model(), 'obtenerPonderacionPorColumna'),
			),
			array(
				'name'=>'medio_verificacion',
				'header'=>'Evaluación Medios de Verificación',
			
			),
		),
	));
  	
  	?>
  </div>
   <div id="banderaDiv" name ="banderaDiv" validarVacio="<?php echo $validarVacios; ?>" style="display:none">aki bandera</div>
<?php }?>
</div>
