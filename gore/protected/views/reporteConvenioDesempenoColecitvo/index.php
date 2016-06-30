<?php 
Yii::app()->clientScript->registerScript('init', "

		$( '#tabs' ).tabs();
		
		$('.mostrarOcultarBotones').each(
    	function(){  
			
    		var idDivBotones = $(this).attr('id');
    		var bandera = $('#'+idDivBotones).attr('bandera');
    		var idAleatoria=Math.floor(Math.random()*11);
    		var hrefPDF=$(this).attr('pdf');
    		var hreWORD=$(this).attr('word');
			if(parseInt(bandera) == parseInt(1)){//hay datos
				$(this).html('<div style=\"float:left\">Exportar a:&nbsp&nbsp&nbsp</div><a id=\"'+idAleatoria+'4\"  name=\"'+idAleatoria+'4\" title=\"Exportar a Pdf\" href=\"'+hrefPDF+'\"><div class=\"iconoPdf\" id =\"'+idAleatoria+'3\" style=\"float:right\"></div></a><a id=\"'+idAleatoria+'1\"  name=\"'+idAleatoria+'1\" title=\"Exportar a MS Word\" href=\"'+hreWORD+'\"><div class=\"iconoWord\" id =\"'+idAleatoria+'2\" style=\"float:right\"></div></a>');
			}else{//no hay datos
		
			}
    
    	});
		
");	

$this->breadcrumbs = array(
		Yii::t('ui','Reportes')=>array('/reportes'),
		'Convenio Desempeño Colectivo',
	);
	
date_default_timezone_set("America/Santiago");

$anio = date("Y");

$divisiones = $model->getData();
?>

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

for($j=0; $j<count($divisiones); $j++){
	$validarVacios=0;
	$id=$divisiones[$j]['id'];
	$datos = Indicadores::model()->indicadoresCDC($id, 1);
	
	$datos = $datos->getData();

	if(count($datos)!=0){
		$validarVacios = 1;
	}
?>

 
  <div id="<?php echo 'tabs-'.$j; ?>">
  <div id="grillaDatos" class="contenedorGridReportecdc">

<div style="float:right;" 
pdf="<?php  echo Yii::app()->request->baseUrl.'/reporteConvenioDesempenoColecitvo/reportes?pdf=1&id='.$id.'&anio='.$anio.'&division='.$divisiones[$j]['nombre']; ?>" 
id="<?php echo 'contenedoricono'.$j ?>" bandera="<?php echo $validarVacios ?>"
word="<?php echo Yii::app()->request->baseUrl.'/reporteConvenioDesempenoColecitvo/reportes?doc=1&id='.$id.'&anio='.$anio.'&division='.$divisiones[$j]['nombre']; ?>" 
class="mostrarOcultarBotones">
</div>
<br></br>
  	<?php   		


	$this->widget('zii.widgets.grid.CGridView', array(
	   	'dataProvider'=>Indicadores::model()->indicadoresCDC($id, 1),
		'id'=>'items-grid'.$j,
		'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();mostrarBoton();}',
		'columns'=>array(
			array(          
	            'name'=>'id',
				'header'=>'id indicador',
				'htmlOptions'=>array("style"=>"display:none"),
				'headerHtmlOptions'=>array("style"=>"display:none"),	     
       		 ),
			array(          
	            'name'=>'productoEstrategico',
				'header'=>'Producto Estratégico al que se Vincula',	     
       		 ),
			array(          
	            'name'=>'descripcion',
				'header'=>'Descripción Indicador',
       		 ),
       		array(
				'name'=>'id',
				'header'=>'Indicador',
       			'type'=>'raw',
				'value'=>array(Indicadores::model(), 'columnaIndicadorCDC'),
			),
			array(            
	            'name'=>'formulaNew',
				'header'=>'Fórmula de Cálculo',
				'type'=>'raw',
				'value'=>array(TiposFormulas::model(), 'columnaFormulaReporte'),
       		 ),
       		array(           
	            'name'=>'meta_anual',
       		    'header'=>'Meta',
       		),
        	array(
				'name'=>'ponderacion',
				'header'=>'Ponderación',
			),
       		array(           
	            'name'=>'medio_verificacion',
       		    'header'=>'Medios de Verificación',
       		),
       		array(           
	            'name'=>'supuestos',
       		    'header'=>'Supuestos', 
       		),
			array(
				'name'=>'notas',
				'header'=>'Notas',
			),
		),
	));
  	
  	?>
  	</div>
  </div>
<?php }?>
</div>
