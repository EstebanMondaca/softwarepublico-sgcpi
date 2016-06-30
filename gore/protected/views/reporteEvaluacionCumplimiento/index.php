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
		'Evaluación de Cumplimiento',
);

date_default_timezone_set("America/Santiago");
   		$mes = date("F");
	    $anio = date("Y");
	    $dia = date("d");
	    $numeroMesActual = date("n");
	    
	    $fecha = $dia.'/'.$numeroMesActual.'/'.$anio;

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
$meses = array(1  => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4  => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7  => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10  => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre' );

for($j=0; $j<count($divisiones); $j++){
	$validarVacios=0;
	$id=$divisiones[$j]['id'];
	$c = new ConsultasView();
	$indicadores = Indicadores::model()->indicadoresCDC($id, 0);
	if(count($indicadores)!=0){
		$validarVacios = 1;
	}
	
	for($k=0; $k<count($indicadores); $k++){
		$hitosIndicador = HitosIndicadores::model()->ultimoHitoIndicador($indicadores[$k]['id']);
		$ultimoHito = $c->encuentraUltimoHitoAnioAnterior($hitosIndicador,$meses); 
		//print_r($ultimoHito);
		if(isset($ultimoHito['meta_reportada'])){
			$indicadores[$k]['meta_reportada'] = $ultimoHito['meta_reportada'];
			
			if($indicadores[$k]['meta_reportada']>=$indicadores[$k]['meta_anual2']){
				$indicadores[$k]['cumple'] = 'SI';
				
			}else{
				$indicadores[$k]['cumple'] = 'NO';
				$indicadores[$k]['porcentajeCumplimiento'] = 'S.I.';
			}
			if($indicadores[$k]['meta_anual2']!=0){
				$indicadores[$k]['porcentajeCumplimiento'] = ($indicadores[$k]['meta_reportada']*100)/$indicadores[$k]['meta_anual2'];
			}else{
				$indicadores[$k]['porcentajeCumplimiento'] = ($indicadores[$k]['meta_reportada']*100)/1;
			}
		}else{
			$indicadores[$k]['meta_reportada'] = 'S.I.';
			$indicadores[$k]['cumple'] = 'S.I.';
			$indicadores[$k]['porcentajeCumplimiento'] = 'S.I.';
		}

	}

	$dataProvider = new CArrayDataProvider($indicadores, 
		array(
			   'keyField' => 'id',         
			   'id' => 'data', 
			    'pagination'=>array(
			        'pageSize'=>10,
			    ),                   
			)
			
	);
?>

  <div id="<?php echo 'tabs-'.$j; ?>">
  <div id="grillaDatos" class="contenedorGridReportecdc">
  
<div style="float:right;" 
pdf="<?php  echo Yii::app()->request->baseUrl.'/reporteEvaluacionCumplimiento/reportes?pdf=1&id='.$id.'&anio='.$anio.'&division='.$divisiones[$j]['nombre'].'&fecha='.$fecha ?>" 
id="<?php echo 'contenedoricono'.$j ?>" bandera="<?php echo $validarVacios ?>"
word="<?php echo Yii::app()->request->baseUrl.'/reporteEvaluacionCumplimiento/reportes?doc=1&id='.$id.'&anio='.$anio.'&division='.$divisiones[$j]['nombre'].'&fecha='.$fecha ?>" 
class="mostrarOcultarBotones">
</div>
<br></br>
  	<?php   		


	$this->widget('zii.widgets.grid.CGridView', array(
	   	'dataProvider'=>$dataProvider,
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
	            'name'=>'meta_reportada',
       		    'header'=>'Efectivo',
   
       		),
       		 array(           
	            'name'=>'cumple',
       		    'header'=>'Cumple',
       		),
       		array(           
	            'name'=>'porcentajeCumplimiento',
       		    'header'=>'% Cumplimiento',
       		),
        	array(
				'name'=>'ponderacion',
				'header'=>'Ponderación',
			
			),
       		array(           
	            'name'=>'medio_verificacion',
       		    'header'=>'Evaluación Cualitativa',
       			'value'=>'',
	          
       		),

		),
	));
  	
  	?>
  	</div>
  </div>

<?php }?>
</div>
