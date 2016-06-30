<?php 

Yii::app()->clientScript->registerScript('creationComplete', "
		ocultaiconos();
");
$this->breadcrumbs = array(
		Yii::t('ui','Reportes')=>array('/reportes'),
		'Formulario H',
);
$periodoActual = Yii::app()->session['idPeriodoSelecionado'];
$periodo= 'Meta '.$periodoActual;
$t1 = $periodoActual-1;
$t2 = $periodoActual-2;
$t3 = $periodoActual-3;
$t4 = $periodoActual-4;

$nombret1 = 'Efectivo a Junio '.$t1;
$nombret2 = 'Efectivo '.$t2;
$nombret3 = 'Efectivo '.$t3;
$nombret4 = 'Efectivo '.$t4;
$Estimaciont1 = 'Estimación '.$t1;
echo "<h2 align='center'>INDICADORES DE DESEMPEÑO FORMULARIO H AÑO $periodoActual</h2>";
?>

<div style="float:right;" id='contenedoricono'">
<div style="float:left">Exportar a:&nbsp&nbsp</div>
<a id="linkExcel"  name="linkExcel" title="Exportar a Pdf" href="<?php echo Yii::app()->request->baseUrl.'/reportes/formHexportfile?pdf=1'; ?>" >
<div class="iconoPdf" id ="iconoPdf" style="float:right"></div></a>
<a id="linkExcel"  name="linkExcel" title="Exportar a MS Word" href="<?php echo Yii::app()->request->baseUrl.'/reportes/formHexportfile?doc=1'; ?>" >
<div class="iconoWord" id ="iconoWord" style="float:right"></div></a>
</div>

<?php 
$sl="";
$sl ="\n<br/>";
echo "<div style='width: 900px; overflow: auto; scrollTop:auto;' id='contenedorgrilla'>";
$model = new Indicadores();
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->busquedaParaFormularioH(),
    'id' => 'indicadores-grid',
	'summaryText'=>false,
	'afterAjaxUpdate'=>'function(){afterAjaxUpdateSuccess();ocultaiconos();}',
    'columns'=>array(
     	array(
    			'name'=>'producto_estrategico',
     			'value'=>'$data->productoEspecifico->subproducto->productoEstrategico',
     			'header'=>'Producto Estratégico al que se Vincula',
     			
     			),
    	array(
    				'header'=>'Descripción<br/>Indicador',
    				'name'=>'descripcion',
    				'type'=>'raw',
    			),
    	array(
    				'name'=>'id',
    				'htmlOptions'=>array('width'=>'145'),
    				'header'=>'Indicador',
    				'type'=>'raw',
    				'value'=>array(Indicadores::model(), 'columnaIndicadorCDC'),
    	),
//     	array(
//     			'name'=>'nombre',
//     			'header'=>'Indicador',
//     			'type'=>'raw',
//     			'value'=>'"$data->nombre<br/><br/> "."$data->descripcion"."Dimensión $data->clasificacionDimension "."Ambito $data->clasificacionAmbito ".$data->productoEspecifico->subproducto->productoEstrategico->desagregado_sexo',
//     			),
    	array(
    			'name'=>'formula',
    			'type'=>'raw',
    			'header'=>'Fórmula de Cálculo',
    			'value'=>'"$data->formula </br></br>"."<b>Tipo Formula :</b> $data->tipoFormula"',
    			'htmlOptions'=>array('width'=>'100'),
    			),
//     	array(
//     			'name'=>'estado',
//     			'header'=>$nombret4,
//     			),
//     	array(
//     			'name'=>'efectivot3',
//     			'header'=>$nombret3,
//     			),
//     	array(
//     			'name'=>'efectivot2',
//     			'header'=>$nombret2,
//     			),
//     	array(
//     			'name'=>'efectivot1',
//     			'header'=>$nombret1,
//     			),
//     	array(
//     			'name'=>'estado',
//     			'header'=>$Estimaciont1,
//     			),
    	array(
    			'name'=>'meta_anual',
    			'header'=>$periodo,
				'type'=>'raw',
    			'value'=>'"A: $data->conceptoa </br>B: $data->conceptob </br>C: $data->conceptoc </br>".$data->tipoFormula->unidad." $data->meta_anual%"',
    			),
    	array(
    			'name'=>'ponderacion',
    			'header'=>'Ponde-<br/>ración',
				'type'=>'raw',
    			'value'=>'$data->ponderacion."%"',
    			),
    	array(
    			'name'=>'medio_verificacion',
    			'header'=>'Medios de <br> Verificación',
				'htmlOptions'=>array('width'=>'100'),
    			),
    	array(
    			'name'=>'supuestos',
    			'header'=>'Supuestos',
				'htmlOptions'=>array('width'=>'50'),    			
    			),
    	array(
    			'name'=>'notas',
    			'header'=>'Notas',
				'htmlOptions'=>array('width'=>'50'),
    			),
    ),
));
echo "</div>";
?>