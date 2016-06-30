<?php 
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
    parent.$('#iframeModal').height($('body').outerHeight(true)+20);
    parent.mostrarRegistroAvanceCargado();
    $('body').css('background-color','#FFF');
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
<div class="form" style="width: auto;">
<div id="content">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'avances-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>TRUE),
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
	<br>
	<div class="fieldset2">
				<div class="legend">Avance Indicador (<?php echo $mes;?>)</div>
				<div class="content"> 
					<div class="row">
					<div style="float:left;width:750px;">
						<div id="conceptoa" >
						<b>Valor A:</b> <input name="avance[valorA]" id="valorA" maxlength="2" readonly="readonly" onblur="<?php echo "calcularFormulaRegistroAvances(".$tipo_resultado_formula.','.$meta_anual.");";?>" onkeydown="validarNumeros(event);" type="text"  style="/*display:none;*/" value="<?php echo $modelHitos->conceptoa;?>" maxlength="5" size="5">
						&nbsp;&nbsp; <?php echo " Meta: ".$modelindicadores->conceptoa; ?>
						<br>
						</div>
						<div id="conceptob" >
						<b>Valor B:</b> <input name="avance[valorB]" id="valorB" maxlength="2" readonly="readonly" onblur="<?php echo "calcularFormulaRegistroAvances(".$tipo_resultado_formula.','.$meta_anual.");";?>" onkeydown="validarNumeros(event);" type="text" value="<?php echo $modelHitos->conceptob;?>" maxlength="5" size="5">
						&nbsp;&nbsp; <?php echo " Meta: ".$modelindicadores->conceptob; ?>
						<br>
						</div>
						<div id="conceptoc" >
						<b>Valor C:</b> <input name="avance[valorC]" id="valorC" maxlength="2" readonly="readonly" onblur="<?php echo "calcularFormulaRegistroAvances(".$tipo_resultado_formula.','.$meta_anual.");";?>" onkeydown="validarNumeros(event);" type="text"  value="<?php echo $modelHitos->conceptoc;?>" maxlength="5" size="5">
						&nbsp;&nbsp; <?php echo " Meta: ".$modelindicadores->conceptoc; ?>
						</div>
					</div>
					
					<div class="fieldsetFormula">
						<div class="legend">Fórmula</div>
						<div class="content" id="formula" ><b><?php echo $modelindicadores->tipos_formulas_formula; ?> </b></div>
					</div>
					</div>
					<div class="row">
						<b>Avance Reportado:<input name="avance[calculo]" type="text" id="inputResultadoCalculoFormula" size="7" value="" readonly="readonly"> <spam class="errorMessage" id="resultadoCalculoFormula"></spam></b>
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
			array(
					'header'	=>'Avance Anterior',
					'value'	=>'(("'.$mesAnterior.'" != "")?HitosActividades::model()->findBySql(
					   "SELECT avance_actual
						FROM hitos_actividades t
						WHERE t.id_actividad= $data->id AND t.actividad_mes=\"'.$mesAnterior.'\""
					  )->avance_actual:"-")',
			
					'type'=>'raw',
			),
	
	    ),
	)); 
	echo "<input style='display:none'  name='actividades[0]'>";
	
	?>		                   
	<div id="contenedorExcel" style="float:right"></div>
	                       
	<div id="documentoActividad">
		Reporte de Avance de Actividades : &nbsp;&nbsp;&nbsp;
		
		<?php 
			if(!empty($modelHitos->evidencia_actividad) )
			{
				
				echo "<a id='actividadesReporteLink' target='_blank' href='".Yii::app()->request->baseUrl.'/upload/doc/'.$modelHitos->evidencia_actividad."'>".$modelHitos->evidencia_actividad."</a>";
				//echo "<a id='actividadesReporteBorrar' class='delete' href='#' onclick='borrarArchivoRegistroAvance(".$modelHitos->id.",\"evidencia_actividad\",\"actividadesReporte\");' title='Eliminar'> <img alt='Eliminar' src='/gore/images/delete.png'> </a>";
				//echo "<input id='actividadesReporte' type='file' accept='application/pdf' style='display:none'  name='avance[documentoActividad]'>";
								
			}else{
				
				//echo "<input id='actividadesReporte' type='file' accept='application/pdf' name='avance[documentoActividad]'>";
			}
		?> 
		<div id="actividadesReporte_em_" class="errorMessage" style="display:none"></div>

	
	</div>
	
	<div class="limpia"></div>
	
	<div id="documentoIndicador">
		Medio de Verificación del Indicador : &nbsp;&nbsp;&nbsp;
		<?php 
			if(!empty($modelHitos->evidencia) )
			{
				
				echo "<a id='mediosVerificacionLink' target='_blank' href='".Yii::app()->request->baseUrl.'/upload/doc/'.$modelHitos->evidencia."'>".$modelHitos->evidencia."</a>";
				//echo "<a id='mediosVerificacionBorrar' class='delete' href='#' onclick='borrarArchivoRegistroAvance(".$modelHitos->id.",\"evidencia\",\"mediosVerificacion\");' title='Eliminar'> <img alt='Eliminar' src='/gore/images/delete.png'> </a>";
				//echo "<input id='mediosVerificacion' type='file' accept='application/pdf' style='display:none'  name='avance[documentoIndicador]'>";
				
			}else{
				
				//echo "<input id='mediosVerificacion' type='file' accept='application/pdf' name='avance[documentoIndicador]'>";
			}
		?> 
		<div id="mediosVerificacion_em_" class="errorMessage" style="display:none"></div>
		
	</div>	
	<div class="limpia"></div>
<?php
	//echo GxHtml::submitButton(Yii::t('app', 'Save'));
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
  	/*{
  	  	'id':'CierresInternos_id_etapa','inputID':'CierresInternos_id_etapa','errorID':'CierresInternos_id_etapa_em_','model':'CierresInternos','name':'id_etapa','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) 
  	  	{

			if($.trim(value)!='') {
				if(!value.match(/^\s*[+-]?\d+\s*$/)) {
					messages.push("Etapas debe ser entero.");
				}
			}
		}
	},
	{
		'id':'CierresInternos_observaciones','inputID':'CierresInternos_observaciones','errorID':'CierresInternos_observaciones_em_','model':'CierresInternos','name':'observaciones','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute) 
		{
			if($.trim(value)=='') {
				messages.push("Observaciones no puede ser nulo.");
			}
		}
	},*/
	{
		'id':'actividadesReporte','inputID':'actividadesReporte','errorID':'actividadesReporte_em_','model':'Actividades','name':'documento','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute)
		{
			if($.trim(value)!='') {
				var cadena = $.trim(value);
				var ext = cadena.split('.').pop().toLowerCase();
				if( cadena==$("#mediosVerificacion").val() ){
					messages.push("Archivo Duplicado");
				}
				
				if($.inArray(ext, ['pdf']) == -1) {
					messages.push("Reporte de Avance de Actividades: Acepta solo archivos PDF");
				}
				
			}
		}
	},
	{
		'id':'mediosVerificacion','inputID':'mediosVerificacion','errorID':'mediosVerificacion_em_','model':'Actividades','name':'documento','enableAjaxValidation':false,'clientValidation':function(value, messages, attribute)
		{
			
			if($.trim(value)!='') {
				var cadena = $.trim(value);
				var ext = cadena.split('.').pop().toLowerCase();
				if( cadena==$("#actividadesReporte").val() ){
					messages.push("Archivo Duplicado");
				}
				
				if($.inArray(ext, ['pdf']) == -1) {
					messages.push("Medio de Verificación del Indicador: Acepta solo archivos PDF");
				}
				
			}
		}
	},
	
	],'summaryID':'avances-form_es_'});
});
/*]]>*/
</script>
