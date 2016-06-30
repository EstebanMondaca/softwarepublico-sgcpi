<?php 
Yii::app()->clientScript->registerScript('init', "
    /*$('#avances-form').on('submit', function(e) {
          if(){
              
          }  
        
    });*/
        
");

//

//echo $modelindicadores->tipo_formula_id;
//Busnanco si la formula es promedio o porcentaje
$tipo_resultado = TiposFormulas::model()->find(array('condition'=>'id='.$modelindicadores->tipo_formula_id));
// 0=PROMEDIO
// 1=PORCENTAJE
$tipo_resultado_formula = $tipo_resultado->tipo_resultado;
$meta_anual=$modelindicadores->meta_anual;
//echo $tipo_resultado->tipo_resultado;
Yii::app()->clientScript->registerCoreScript('jquery'); 
Yii::app()->clientScript->registerCoreScript('yiiactiveform'); 


Yii::app()->clientScript->registerScript('habilitar', "
   
    //cambiando alto del iframe en caso de estar solicitando esta vista desde lineas de acción
    parent.$('#iframeModal').height($('html').height());
");

Yii::app()->clientScript->registerScript('restrictCbSelection','
    $(document).ready(function(){
    	calcularFormulaRegistroAvances('.$tipo_resultado_formula.','.$meta_anual.');  
        
	});
');



date_default_timezone_set("America/Santiago");
$dia=date("j"); 
$mes=date("F"); // November
$anio=date("Y"); // 2012 
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
 
//echo strtoupper($frecuenciaControl);
$mes= $modelHitos->mes;

$meses;
if(strtoupper($frecuenciaControl)=='MENSUAL'){
	$meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
}else{
	$meses = array('marzo','junio','septiembre','diciembre');
}
//Buscamos la clave del mes en proceso para obtener el indice anterior segun segun arreglo.
$mesClave = array_search($mes, $meses);
$mesAnteriorClave;
$mesAnterior="";
//echo $mesClave;
if($mesClave>0){
	$mesAnteriorClave=$mesClave-1;
    $mesAnterior= $meses[$mesAnteriorClave];
}
//echo $mesAnterior;



?>
<div class="form">
<div id="content">

<h3>INDICADOR: <?php echo $nombre_i;?></h3>
<div id="avances-form_es_" class="errorSummary" style="display:none">
	<p>Por favor corrija los siguientes errores de ingreso:</p>
	<ul>
		<li></li>
	</ul>
</div>

<table class="tablaRegistroAvance">
  <tr>
    <th>Producto Estratégico:&nbsp;&nbsp;</th>
    <th><?php echo $nombre_productoEst;?></th>
  </tr>
  <tr>
    <td>Subproducto:&nbsp;&nbsp;</td>
    <td><?php echo $nombre_sub;?></td>
  </tr>
    <tr>
    <td>Producto Específico:&nbsp;&nbsp;</td>
    <td><?php echo $nombre_productoEsp?></td>
  </tr>
</table>


<div><h3></h3></div><br>
<div style="float:left"><h4>Avance Esperado : &nbsp;&nbsp;<?php echo $modelHitos->meta_parcial;?>%  </h4></div> 
<div style="float:right">Fecha Actual:&nbsp;&nbsp; <?php echo $mes.' '.$dia.' de '.$anio ?></div>

<div class="limpia"></div>
 <!--  <form id="registro-Avance-form" method="post" action="/gore/panelAvances/registroavance/"> -->

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'avances-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>TRUE),
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
	<br>
	<div class="fieldset2">
				<div class="legend">Avance Indicador</div>
				<div class="content"> 
					<div class="row">
					<div style="float:left;width:750px;">
						<div id="conceptoa" >
						<b>Valor A:</b> <input name="avance[valorA]" id="valorA"  onblur="<?php echo "calcularFormulaRegistroAvances(".$tipo_resultado_formula.','.$meta_anual.");";?>" onkeydown="validarNumeros(event);" type="text"  style="/*display:none;*/" value="<?php echo $modelHitos->conceptoa;?>" maxlength="9" size="10">
						&nbsp;&nbsp; <?php echo " Meta: ".$modelindicadores->conceptoa; ?>
						<br>
						</div>
						<div id="conceptob" >
						<b>Valor B:</b> <input name="avance[valorB]" id="valorB" onblur="<?php echo "calcularFormulaRegistroAvances(".$tipo_resultado_formula.','.$meta_anual.");";?>" onkeydown="validarNumeros(event);" type="text" value="<?php echo $modelHitos->conceptob;?>" maxlength="9" size="10">
						&nbsp;&nbsp; <?php echo " Meta: ".$modelindicadores->conceptob; ?>
						<br>
						</div>
						<div id="conceptoc" >
						<b>Valor C:</b> <input name="avance[valorC]" id="valorC" onblur="<?php echo "calcularFormulaRegistroAvances(".$tipo_resultado_formula.','.$meta_anual.");";?>" onkeydown="validarNumeros(event);" type="text"  value="<?php echo $modelHitos->conceptoc;?>" maxlength="9" size="10">
						&nbsp;&nbsp; <?php echo " Meta: ".$modelindicadores->conceptoc; ?>
						</div>
					</div>
					
					<div class="fieldsetFormula">
						<div class="legend">Fórmula</div>
						<div class="content" id="formula" ><b><?php echo $modelindicadores->tipos_formulas_formula; ?> </b></div>
					</div>
					</div>
					<div class="row">
						<b>Avance Reportado:<input name="avance[calculo]" type="text" id="inputResultadoCalculoFormula" size="13" value="" readonly="readonly"> <spam class="errorMessage" id="resultadoCalculoFormula"></spam></b>
					</div>
				</div>
	</div>
		<?php 
		$this->widget('zii.widgets.grid.CGridView', array(
	    'id' => 'actividades-grid',
		'summaryText' => false,  
	    'dataProvider' => $model,
	    //'filter' => $model,
	    'columns' => array(
	        array(
	            'header'=>'N°',
	            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
	            'htmlOptions'=>array('width'=>'20'),
	        	),
	        	
	        array(
					'header'	=>'Actividades Asociadas',
	        		'value'	=>'$data->nombre',
	        		'type'=>'raw',
	        		'htmlOptions'=>array('width'=>'320px'),
	
			),
	        'fecha_inicio',
	        'fecha_termino',
	       /* array(
					'header'	=>'Avance Anterior',
	        		'value'	=>'(($data->avance_anterior > 0)?($data->avance_anterior."%"):"-")' ,
	        		'type'=>'raw',
	       			'htmlOptions'=>array("width"=>"120px"),
	
			),*/
			array(
					'header'	=>'Avance Anterior',
					'value'	=>'(("'.$mesAnterior.'" != "")?HitosActividades::model()->findBySql(
					   "SELECT avance_actual
						FROM hitos_actividades t
						WHERE t.id_actividad= $data->id AND t.actividad_mes=\"'.$mesAnterior.'\""
					  )->avance_actual:"-")',
			
					'type'=>'raw',
			),
			array(
					'header'	=>'Avance Actual',
			//'value'	=>'Avance Anterior',
					'value' => 'GxHtml::textField("actividades[".$data->idHito."]",$data->avanceActual,array("maxlength" => 3,"style"=>"width:40px;","onkeydown"=>"validarNumeros(event);"))',
					'type'=>'raw',
					'htmlOptions'=>array("width"=>"70px"),		
			), 	
	    ),
	)); 
	echo "<input style='display:none'  name='actividades[0]'>";
	
	?>		                   
	<div id="contenedorExcel" style="float:right">
		<a href="<?php echo Yii::app()->request->baseUrl.'/upload/anexos/Formato_seguimiento_cumplimiento_indicadores.docx'?>">
			<div id="iconoExcel" class="iconoExcel"></div>
			<div style="float:right">Descargar Formato</div>
		</a>
	</div>
	                       
	<div id="documentoActividad">
		Reporte Actividades y Medios de Verificación : &nbsp;&nbsp;&nbsp;
		
		<?php 
			if(!empty($modelHitos->evidencia_actividad) )
			{
				
				echo "<a id='actividadesReporteLink' target='_blank' href='".Yii::app()->request->baseUrl.'/upload/doc/'.$modelHitos->evidencia_actividad."'>".$modelHitos->evidencia_actividad."</a>";
				echo "<a id='actividadesReporteBorrar' class='delete' href='#' onclick='borrarArchivoRegistroAvance(".$modelHitos->id.",\"evidencia_actividad\",\"actividadesReporte\");' title='Eliminar'> <img alt='Eliminar' src='/gore/images/delete.png'> </a>";
				echo "<input id='actividadesReporte' type='file' accept='application/pdf' style='display:none'  name='avance[documentoActividad]'>";
								
			}else{
				
				echo "<input id='actividadesReporte' type='file' accept='application/pdf' name='avance[documentoActividad]'>";
			}
		?> 
		<div id="actividadesReporte_em_" class="errorMessage" style="display:none"></div>

	
	</div>
	
	<div class="limpia"></div>
	<!--  
	<div id="documentoIndicador">
		Medio de Verificación del Indicador : &nbsp;&nbsp;&nbsp;
		<?php 
		/*	if(!empty($modelHitos->evidencia) )
			{
				
				echo "<a id='mediosVerificacionLink' target='_blank' href='".Yii::app()->request->baseUrl.'/upload/doc/'.$modelHitos->evidencia."'>".$modelHitos->evidencia."</a>";
				echo "<a id='mediosVerificacionBorrar' class='delete' href='#' onclick='borrarArchivoRegistroAvance(".$modelHitos->id.",\"evidencia\",\"mediosVerificacion\");' title='Eliminar'> <img alt='Eliminar' src='/gore/images/delete.png'> </a>";
				echo "<input id='mediosVerificacion' type='file' accept='application/pdf' style='display:none'  name='avance[documentoIndicador]'>";
				
			}else{
				
				echo "<input id='mediosVerificacion' type='file' accept='application/pdf' name='avance[documentoIndicador]'>";
			}
		*/	
		?> 
		<div id="mediosVerificacion_em_" class="errorMessage" style="display:none"></div>
		
	</div>	
	<div class="limpia"></div>
	-->
<?php
	echo GxHtml::submitButton(Yii::t('app', 'Save'));
	$this->endWidget();
?>

<div class="limpia"></div>
</div>
</div>

<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
jQuery('a[rel="tooltip"]').tooltip();
jQuery('a[rel="popover"]').popover();
$('#avances-form').yiiactiveform({'validateOnSubmit':true,'attributes':[
	{
		'id':'actividadesReporte','inputID':'actividadesReporte','errorID':'actividadesReporte_em_','model':'Actividades','name':'documento','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute)
		{
			if($.trim(value)!='') {
				var cadena = $.trim(value);
				var ext = cadena.split('.').pop().toLowerCase();
				
				if($.inArray(ext, ['pdf']) == -1) {
					messages.push("Reporte Actividades y Medios de Verificación : Acepta solo archivos PDF");
				}
				
			}
			if($("#actividadesReporte").is(':visible')){
			    if($("#actividadesReporte").val()==""){
			         messages.push("Debe ingresar el Reporte Actividades y Medios de Verificación");			         
			    }
			}
		}
	},
	],'summaryID':'avances-form_es_'});
});
/*]]>*/
</script>
