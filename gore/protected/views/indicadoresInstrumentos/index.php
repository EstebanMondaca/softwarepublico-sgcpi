
<script type="text/javascript">
$("input:checkbox").click(function () {
    var thisCheck = $(this);
    if (thisCheck.is(':checked')){
        // do what you want here, the way to access the text is using the
        // $(this) selector. The following code would output pop up message with
        // the selected checkbox text
        $(this).val();
    }
});


</script>

<?php
$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Index'),
);

$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'indicadores-instrumentos-form',
	'enableAjaxValidation' => false,
));



Yii::app()->clientScript->registerScript('restrictCbSelection','
    $(document).ready(function(){
        $("#indicadores-instrumentos-grid .select-on-check-all").attr("disabled", true).attr("keys", "");
  		
		$("select[name=\"Indicadores[division_id]\"]").attr("onchange","asignarValorExportarExcelIndInst(this.value);");
        $("select[name=\"Indicadores[division_id]\"]").val($("#cr_id").val()); 
		$("select[name=\"Indicadores[division_id]\"]").change();
		
        $("#resumen_input_FH,#resumen_input_CDC,#resumen_input_T").html("");
        
        resumenIndicadoresAsignadosInstrumentos();
        
});');



?>

<h3></h3>
<input type="hidden" id="cr_id" name="cr_id" value="<?php echo (isset($_POST["cr_id"]))?$_POST["cr_id"]:''; ?>">
<table class="grid-viewIndicadoresInstrumentosOne" id="resumen">
	<thead>
		<tr>
			<th> F.H.</th>
			<th>CDC</th>
			<!--<th>PMG</th>
			<th>MG</th> -->
			<th>T</th>
		</tr>
	</thead>
		<tbody>
			<tr class="odd">
				<td id="resumen_input_FH"  width="60"></td>
				<td id="resumen_input_CDC" width="60"></td>
				<!-- <td id="resumen_input_PMG" width="60"></td>
				<td id="resumen_input_MG"  width="60"></td> -->
				<td id="resumen_input_T"   width="60"></td>
			</tr>
			
		</tbody>
</table>

<div id="contenedorExcel" style="float:right;display:none;">
	<a href="<?php echo Yii::app()->request->baseUrl;?>/indicadoresInstrumentos/excel/?id=0">
		<div id="iconoExcel" class="iconoExcel"></div>
		<div style="float:right">Exportar a MS Excel</div>
	</a>
</div>

<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'indicadores-instrumentos-grid',
	'dataProvider' => $indicadores->listadoFiltrado(),
	'filter' => $indicadores,	
	'summaryText' => false,  
	'enablePagination' => false,
	'enableSorting'=> false,//Elimina el link que ordena por indicador (nombre)
	//'emptyText'=> "-_-",
	'afterAjaxUpdate'=>'js:function(id){
	    
		$("select[name=\"Indicadores[division_id]\"]").attr("onchange","asignarValorExportarExcelIndInst(this.value);");
	    
		$("select[name=\"Indicadores[division_id]\"]").val($("#cr_id").val()); 
		//$("select[name=\"Indicadores[division_id]\"]").change();
		
        $("#indicadores-instrumentos-grid .select-on-check-all").attr("disabled", true).attr("keys", "");
        
        
        var total=0;
        $(".datoFH").each(function(){
            if(/^([0-9])*[.]?[0-9]*$/.test($(this).html())){
                total+=parseFloat($(this).html());
            }
        });
        $("#resumen_input_FH").html(total);
        
        var total=0;
        $(".datoCDC").each(function(){
            if(/^([0-9])*[.]?[0-9]*$/.test($(this).html())){
                total+=parseFloat($(this).html());
            }
        });
        $("#resumen_input_CDC").html(total);
        
        var total=0;
        $(".datoT").each(function(){
            if(/^([0-9])*[.]?[0-9]*$/.test($(this).html())){
                total+=parseFloat($(this).html());
            }
        });
        $("#resumen_input_T").html(total);
        
        
        //resumenIndicadoresAsignadosInstrumentos();
    }',
	'selectionChanged'=>'js:function(id){
        var keys = $("#indicadores-instrumentos-grid .select-on-check-all").attr("keys");
        if (keys != undefined){
        var sels = $("#" + id).yiiGridView("getSelection")
        var ext = $(sels).not(keys.split(","))
        if( $("#"+id+" :checked").size() <= 3 )  
            $("#indicadores-instrumentos-grid .select-on-check-all").attr("keys", sels.join(","));
        else
            $("#indicadores-instrumentos-grid .select-on-check[value="+ext[0]+"]").click().prop("checked",false);
        }
        
        
        
	}',
	'columns' => array(
	 	array(
            'header'=>'N°',
            'htmlOptions'=>array('width'=>'20'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
		array(
				'value'		=>'$data->ambito_n',
				'header'	=>'Ámbito',
				),            
		array(
				'name'		=>'division_id',
				'value'=>'$data->division_n',
				'header'	=>'Centro Responsabilidad',
				//$('#contenedorExcel a').attr({'href': baseURL+'/indicadoresInstrumentos/excel/?id='+this.value})
				'filter'=>GxHtml::listDataEx(Divisiones::model()->findAll(array('condition'=>'estado=1'))),
				),
		array(
				//'value'		=>'$data->centro_costo_id',
				'value'=>'(($data->centro_costo_id=="")?Indicadores::model()->find(array(
						"condition" => "t.estado =1 AND t.id =$data->id  AND producto_especifico_id IS NULL",
						"join" => "INNER JOIN lineas_accion li ON t.id = li.id_indicador 
								   LEFT JOIN centros_costos cc ON li.centro_costo_id = cc.id",
						"select" => "cc.nombre",		   
						)):CentrosCostos::model()->find("estado=1 AND id=$data->centro_costo_id"))',
				'header'	=>'C.C.',
		),			
       /* array(
				'name'		=>'cargo',
				'header'	=>'Cargo',
				),
		*/			
		array(
				'value'		=>'$data->producto_estrategico_n',
			   	'header' 	=> 'Prod. Estratégico',

		),	
		array(
			   	'header' 	=> 'SubProducto',
				'value' => '(($data->subproducto_n=="")?"-":$data->subproducto_n)'

		),	
		array(
				//'name'		=>'producto_especifico_n',
			   	'header' 	=> 'Prod. Específico /AMI/LA',
				'value' => '(($data->subproducto_n=="")?LineasAccion::model()->find("id_indicador=".$data->id):$data->subproducto_n)'
			
		),	
		array(
				'value'		=>'$data->nombre',
				'header'	=>'Indicador'
		),
		array(
				'header'	=>'MG',
				'htmlOptions'=>array('width'=>'40'),
				'id'       => 'mg.$data->id',
				//'value' => '(($data->mg==" ")?"-":(($data->mg!="PMG")?"MG".GxHtml::textField("indicadoresInstrumentos[MG][$data->id]",$data->ponderacionmg,array("maxlength" => 4,"style"=>"width:30px;","onkeydown"=>"maskInputFloat(event);","onBlur"=>"if(this.value >= 0) {resumenIndicadoresAsignadosInstrumentos();}else{this.value=null;this.focus();}","class"=>"input_MG")):$data->mg."&nbsp;".GxHtml::textField("indicadoresInstrumentos[PMG][$data->id]",$data->ponderacionpmg,array("maxlength" => 4,"style"=>"width:30px;","onkeydown"=>"maskInputFloat(event);","onBlur"=>"if(this.value >= 0) {resumenIndicadoresAsignadosInstrumentos();}else{this.value=null;this.focus();}","class"=>"input_PMG"))))',
				'value' => '(($data->mg==" ")?"-&nbsp;&nbsp;&nbsp":(($data->mg!="PMG")?"MG&nbsp;&nbsp;&nbsp;":$data->mg."&nbsp;&nbsp;&nbsp"))',				
				'type'=>'raw',
				'htmlOptions'=>array("width"=>"80px","style"=>"text-align: right","class"=>"check_FH"),
		),
		array(
				'header'	=>'F.H',
				//'value' => '(($data->mg!=" ")?"-":GxHtml::checkBox("check[FH][$data->id]",($data->ponderacionfh)?true:false,array("onclick"=>"activarTextField(this)","class"=>"check_FH")).GxHtml::textField("indicadoresInstrumentos[FH][$data->id]",$data->ponderacionfh,array("maxlength" => 4,"disabled"=>"disabled","style"=>"width:30px;display:none;","onkeydown"=>"maskInputFloat(event);","onBlur"=>"if(this.value >= 0) {resumenIndicadoresAsignadosInstrumentos();}else{this.value=null;this.focus();}","class"=>"input_FH")))',
				'value'=>'($data->mg!=" ")?"-":$data->ponderacionfh',
				'type'=>'raw',
				'htmlOptions'=>array("width"=>"70px",'class'=>'datoFH'),
		),
		array(
				'header'	=>'CDC',	
				//'value' => 'GxHtml::checkBox("CDC[$data->id]",($data->ponderacioncdc)?true:false,array("onclick"=>"activarTextField(this)","class"=>"check_CDC")).GxHtml::textField("indicadoresInstrumentos[CDC][$data->id]",$data->ponderacioncdc,array("maxlength" => 4,"disabled"=>"disabled","style"=>"width:30px;display:none;","onkeydown"=>"maskInputFloat(event);","onBlur"=>"if(this.value >= 0) {resumenIndicadoresAsignadosInstrumentos();}else{this.value=null;this.focus();}","class"=>"input_CDC"))',
				'value'=>'(isset($data->ponderacioncdc))?$data->ponderacioncdc:"-"',
				'type'=>'raw',
				'htmlOptions'=>array("width"=>"70px",'class'=>'datoCDC'),		
		),
		array(
				'header'	=>'T',
				//'value' => 'GxHtml::checkBox("T[$data->id]",($data->ponderaciont)?true:false,array("onclick"=>"activarTextField(this)","class"=>"check_T")).GxHtml::textField("indicadoresInstrumentos[T][$data->id]",$data->ponderaciont,array("maxlength" => 4,"disabled"=>"disabled","style"=>"width:30px;display:none;","onkeydown"=>"maskInputFloat(event);","onBlur"=>"if(this.value >= 0) {resumenIndicadoresAsignadosInstrumentos();}else{this.value=null;this.focus();}","class"=>"input_T"))',
				'value'=>'(isset($data->ponderaciont))?$data->ponderaciont:"-"',
				'type'=>'raw',
				'htmlOptions'=>array("width"=>"70px",'class'=>'datoT'),		
		),
		/*'ponderacion',*/
	),
)); 


/*
$this->menu = array(
		array('label'=>'Guardar', 'url'=>array('create')),
	);
	*/
	//echo GxHtml::submitButton(Yii::t('app', 'Save'));
	$this->endWidget();
	?>
	<?php
    Yii::app()->clientScript->registerScript('delete-item', "

    $('#export-button').on('click',function() {

        $.fn.yiiGridView.export();
    });
    $.fn.yiiGridView.export = function() {
        $.fn.yiiGridView.update('indicadores-instrumentos-grid',{ 
            success: function() {
                $('#indicadores-instrumentos-grid').removeClass('grid-view-loading');
                window.location = '". $this->createUrl('exportFile')  . "';
            },
            data: 'export=true'
        });
    }
    ");
   ?>
	