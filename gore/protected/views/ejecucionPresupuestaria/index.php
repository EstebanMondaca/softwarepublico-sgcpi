<?php

	Yii::app()->clientScript->registerScript('change', "
    
    $('#combo2').change(function() {
    
  
    	mostrarEjecucionPresupuestaria($('#combo2').val(), $('#combo1').val());  
    	var centroId = $('#combo2').val();
    	var divisionId = $('#combo1').val();
    	
    	var nombreDivision = $('#combo1 option:selected').text();
    	var nombreCC = $('#combo2 option:selected').text();
    	var link=$('#linkExcel').attr('rel');
    	$('#linkExcel').attr('href',link+'?id='+centroId+'&id2='+divisionId+'&nombreDivision='+nombreDivision+'&nombreCC='+nombreCC);
	
       
    });
");
	

?>

<h3>Registro de Ejecución Presupuestaria</h3>


<div  style="float: left">Centro de Responsabilidad: &nbsp;&nbsp;&nbsp;
<?php 
		//combobox de divisiones
		echo CHtml::dropDownList(
		'combo_d',""
		,array('0'=>'Seleccione División')+CHtml::listData(Divisiones::model()->findAll(array('condition'=>'estado = 1')),'id','nombre')
		,array('id'=>'combo1', 'onchange'=>'js:mostrarCentrosCostos(this.value, 0);','class'=>'selectorIndicadores')
		);
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<div>Centro de Costos: &nbsp;&nbsp;&nbsp;
<?php 

		//combobox centros costos
		echo CHtml::dropDownList(
		'centroCostos',""
		,array('0'=>'Seleccione Centro de Costos')
		,array('id'=>'combo2','class'=>'selectorIndicadores')
		);

?>
</div>

<div style="float:right; display:none" id='contenedorExcel'><a id="linkExcel"  href="<?php echo Yii::app()->request->baseUrl.'/ejecucionPresupuestaria/excel2'?>" rel="<?php echo Yii::app()->request->baseUrl.'/ejecucionPresupuestaria/excel2/'?>"><div class="iconoExcel" id ="iconoExcel"></div><div style="float:right">Exportar a MS Excel</div></a></div>
<div class="limpia"></div>
<div id="grillaDatos" style="display:none" class="contenedorGridEjecucionPresupuestaria">
<?php 

$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'ejecucion-presupuestaria-form',
	'enableAjaxValidation' => false,
	
));

?>

<div class="limpia"></div>
<?php 


$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'items-grid',
	'dataProvider' => $dataProvider,
	'summaryText' => false,  
	'enablePagination' => true,
	'afterAjaxUpdate'=>'function(){afterAjaxUpdateSuccess();mostrarBoton();}',
	'columns' => array(

		array(
			
			'name'=>'id_division',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][id_division]","$data[id_division]", array("style"=>"display:none"))',
            'htmlOptions'=>array("style"=>"display:none"),
			'headerHtmlOptions'=>array("style"=>"display:none"),
		),
		array(
			
			'name'=>'id',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][id]","$data[id]", array("style"=>"display:none"))',
            'htmlOptions'=>array("style"=>"display:none"),
			'headerHtmlOptions'=>array("style"=>"display:none"),
		),
		array(
			
			'name'=>'monto_asignado',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][asignado]","$data[monto_asignado]", array("style"=>"display:none"))',
            'htmlOptions'=>array("style"=>"display:none"),
			'headerHtmlOptions'=>array("style"=>"display:none"),
		),
		array(
			
			'name'=>'id_item',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][id_item]","$data[id_item]", array("style"=>"display:none"))',
            'htmlOptions'=>array("style"=>"display:none"),
			'headerHtmlOptions'=>array("style"=>"display:none"),
		),
		array(
			'name'=>'id',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][cc]","$data[id_centro_costo]", array("style"=>"display:none"))',
            'htmlOptions'=>array("style"=>"display:none"),
			'headerHtmlOptions'=>array("style"=>"display:none"),
		),
		
	 	array('header'=>'Nº',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
			
        array(
			'name'=>'item_nom',
			'header'=>'Item',
		),
		array(
			//'name'=>'monto_asignado',
			'value'=>'"$".number_format($data["monto_asignado"],0, "", ".")',    
			'header'=>'Monto Asignado',
			'htmlOptions'=>array("class"=>"asignado"), 
		),

		
		array(
			'header'=>'Enero',
            'name'=>'mes1',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][mes1]","$data[mes1]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
        ),
		array(
			'header'=>'Febrero',
			'name'=>'mes2',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][mes2]","$data[mes2]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Marzo',
			'name'=>'mes3',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][mes3]","$data[mes3]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),

		),
		array(
			'header'=>'Abril',
			'name'=>'mes4',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][mes4]","$data[mes4]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Mayo',
			'name'=>'mes5',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][mes5]","$data[mes5]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Junio',
			'name'=>'mes6',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][mes6]","$data[mes6]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Julio',
			'name'=>'mes7',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][mes7]","$data[mes7]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Agosto',
			'name'=>'mes8',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][mes8]","$data[mes8]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Septiembre',
			'name'=>'mes9',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][mes9]","$data[mes9]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Octubre',
			'name'=>'mes10',
            'type'=>'raw',
            'value'=>'CHtml::textField("eP[$data[id_item]][mes10]","$data[mes10]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Noviembre',
			'name'=>'mes11',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][mes11]","$data[mes11]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Diciembre',
			'name'=>'mes12',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][mes12]","$data[mes12]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),

		 array(            
            'name'=>'acumulado',
		 	'header'=>'Acumulado a la Fecha ($)',
		    'htmlOptions'=>array("class"=>"acumulado"),       
        ),
		
		array(
			
			'name'=>'acumulado',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][acumulado]","$data[acumulado]")',
            'htmlOptions'=>array("class"=>"acumuladoInput", "style"=>"display:none"),
			'headerHtmlOptions'=>array("style"=>"display:none"),
		),
		array(
			'name'=>'saldo',
			'header'=>'Saldo ($)',
			'htmlOptions'=>array("class"=>"saldo"), 

		),
		array(
			
			'name'=>'saldo',
            'type'=>'raw',
            'value'=>'GxHtml::textField("eP[$data[id_item]][saldo]","$data[saldo]", array("style"=>"display:none"))',
            'htmlOptions'=>array("class"=>"saldoInput", "style"=>"display:none"),
			'headerHtmlOptions'=>array("style"=>"display:none"),
		),


	),
)); 

?>

<?php 
$this->endWidget();
?>
</div>
    <div id="botonGuardar" style = "display:none">

  <input type="button" value="Guardar" id="btnG" onclick="obtieneDatosFormularioEjecucionPresupuestaria()">

</div>
<div class="limpia"></div>




