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
			'name'=>'item_nom',
			'header'=>'Item',
		),
		array(
			//'name'=>'monto_asignado',	
			'value'=>'"$".number_format($data["monto_asignado"],0, "", ".")',	
			'type'=>'raw',	
			'header'=>'Monto Asignado',
			'htmlOptions'=>array("class"=>"asignado"), 
		),

		
		array(
			'header'=>'Enero',
            //'name'=>'mes1',
            'value'=>'"$".number_format($data["mes1"],0, "", ".")',
            'type'=>'raw',
        //    'value'=>'GxHtml::textField("eP[$data[id_item]][mes1]","$data[mes1]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
        ),
		array(
			'header'=>'Febrero',
			//'name'=>'mes2',
			'value'=>'"$".number_format($data["mes2"],0, "", ".")',
            'type'=>'raw',
         //   'value'=>'GxHtml::textField("eP[$data[id_item]][mes2]","$data[mes2]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Marzo',
			//'name'=>'mes3',
			'value'=>'"$".number_format($data["mes3"],0, "", ".")',
            'type'=>'raw',
        //    'value'=>'GxHtml::textField("eP[$data[id_item]][mes3]","$data[mes3]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),

		),
		array(
			'header'=>'Abril',
			//'name'=>'mes4',
			'value'=>'"$".number_format($data["mes4"],0, "", ".")',
            'type'=>'raw',
        //    'value'=>'GxHtml::textField("eP[$data[id_item]][mes4]","$data[mes4]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Mayo',
			//'name'=>'mes5',
			'value'=>'"$".number_format($data["mes5"],0, "", ".")',
            'type'=>'raw',
         //   'value'=>'GxHtml::textField("eP[$data[id_item]][mes5]","$data[mes5]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Junio',
			//'name'=>'mes6',
			'value'=>'"$".number_format($data["mes6"],0, "", ".")',
            'type'=>'raw',
       //     'value'=>'GxHtml::textField("eP[$data[id_item]][mes6]","$data[mes6]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Julio',
			//'name'=>'mes7',
			'value'=>'"$".number_format($data["mes7"],0, "", ".")',
            'type'=>'raw',
          //  'value'=>'GxHtml::textField("eP[$data[id_item]][mes7]","$data[mes7]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Agosto',
			//'name'=>'mes8',
			'value'=>'"$".number_format($data["mes8"],0, "", ".")',
            'type'=>'raw',
          //  'value'=>'GxHtml::textField("eP[$data[id_item]][mes8]","$data[mes8]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Septiembre',
			//'name'=>'mes9',
			'value'=>'"$".number_format($data["mes9"],0, "", ".")',
            'type'=>'raw',
        //    'value'=>'GxHtml::textField("eP[$data[id_item]][mes9]","$data[mes9]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Octubre',
			//'name'=>'mes10',
			'value'=>'"$".number_format($data["mes10"],0, "", ".")',
            'type'=>'raw',
       //     'value'=>'CHtml::textField("eP[$data[id_item]][mes10]","$data[mes10]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Noviembre',
			//'name'=>'mes11',
			'value'=>'"$".number_format($data["mes11"],0, "", ".")',
            'type'=>'raw',
          //  'value'=>'GxHtml::textField("eP[$data[id_item]][mes11]","$data[mes11]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),
		array(
			'header'=>'Diciembre',
			//'name'=>'mes12',
			'value'=>'"$".number_format($data["mes12"],0, "", ".")',
            'type'=>'raw',
         //   'value'=>'GxHtml::textField("eP[$data[id_item]][mes12]","$data[mes12]", array("style"=>"width:38px;font-size:12px;","onkeydown"=>"maskInput(event);","onkeyup"=>"calcularAcumuladoEjecucionPresupuestaria(this);"))',
            'htmlOptions'=>array("width"=>"50px","class"=>"mes"),
		),

		 array(            
            //'name'=>'acumulado',
            'value'=>'"$".number_format($data["acumulado"],0, "", ".")',
		 	'header'=>'Acumulado a la Fecha ($)',
		    'htmlOptions'=>array("class"=>"acumulado"),       
        ),

		array(
			//'name'=>'saldo',
			'value'=>'"$".number_format($data["saldo"],0, "", ".")',
			'header'=>'Saldo ($)',
			'htmlOptions'=>array("class"=>"saldo"), 

		),



	),
)); 

?>

<?php 
$this->endWidget();
?>
</div>
<div class="limpia"></div>
