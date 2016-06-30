<?php 
Yii::app()->clientScript->registerScript('init', "
    	    	
		circulosRojosReporteAvanceIndicadores();
		validarAnchoTabla();
		$('#combo2').attr('disabled','disabled');
		$('#combo_gestor').attr('disabled','disabled');
		$('#combo_producto_estrategico').attr('disabled','disabled');
		$('#combo_subproducto').attr('disabled','disabled');
		$('#combo_pre_especifico').attr('disabled','disabled');
		$('#combo_producto_estrategico').attr('disabled','disabled');
	
");
Yii::app()->clientScript->registerScript('ready', "
    
    $(document).ready(function() {
    
   		 obtenerDatosExcelReporteAvancesIndicadores();
    
    });
");
?>
<h3>Reporte de Avance de Indicadores</h3>
<div class="actividadesContenedor">
<?php 
$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'reporte-avance-indicadores-form',
	'enableAjaxValidation' => false,
	//'action' => Yii::app()->request->baseUrl.'/reporteAvanceIndicadores/obtenerIndicadoresFiltrados'
	
));
?>
<h2>Selección de Filtros</h2>
<table >
<tr>
<td WIDTH="900"><div  style="float: left">Centro de Responsabilidad: &nbsp;&nbsp;&nbsp;</div></td>
<td WIDTH="900"><div  style="float: left">Centro de Costo: &nbsp;&nbsp;&nbsp;</div></td>
<td WIDTH="900"><div  style="float: left">Gestor: &nbsp;&nbsp;&nbsp;</div></td>
</tr>
<tr>
<td>

<?php
//comienza el form


		echo CHtml::dropDownList(
		'Indicadores[divisionNombre]',""
		,array('0'=>'Seleccione Centro de Responsabilidad')+CHtml::listData(Divisiones::model()->findAll(array('condition'=>'estado = 1', 'order'=>'nombre')),'id','nombre')
		,array('id'=>'combo1', 'onchange'=>'mostrarCentrosCostosReporteAvanceIndicadores(this.value);','class'=>'selectorIndicadores')
		);

?>
</td>
<td>

<?php
		echo CHtml::dropDownList(
		'Indicadores[centroCostoNombre]',""
		,array('0'=>'Seleccione Centro de Costos')
		,array('id'=>'combo2','class'=>'selectorIndicadores', 'onchange'=>'js:mostrarGestoresReporteAvanceIndicadores(this.value);')
		);

?>

</td>
<td>

<?php
		echo CHtml::dropDownList(
		'Indicadores[responsableNombre]',""
		,array('0'=>'Seleccione Gestor')
		,array('id'=>'combo_gestor','class'=>'selectorIndicadores', 'onchange'=>'js:obtenerDatosExcelReporteAvancesIndicadores();')
		);
?>

</td>
</tr>
<tr>
<td><div  style="float: left">Tipo Producto: &nbsp;&nbsp;&nbsp;</div></td>
<td><div  style="float: left">Producto Estratégico: &nbsp;&nbsp;&nbsp;</div></td>
<td><div  style="float: left">Subproducto: &nbsp;&nbsp;&nbsp;</div></td>
</tr>
<tr>
<td>
<?php
		 echo CHtml::dropDownList(
		'Indicadores[tipoProductoEstrategico]',""
		,array('0'=>'Seleccione Tipo Producto')+CHtml::listData(TiposProductos::model()->findAll(array('condition'=>'estado = 1')),'id','nombre')
		,array('id'=>'combo_tipo_prodcuto', 'onchange'=>'js:mostrarProductosEstrategicosReporteAvanceIndicadores(this.value, 0);','class'=>'selectorIndicadores')
		);

?>
</td>
<td>
<?php
		echo CHtml::dropDownList(
		'Indicadores[productoEstrategicoNombre]',""
		,array('0'=>'Seleccione Producto Estratégico')
		,array('id'=>'combo_producto_estrategico','class'=>'selectorIndicadores', 'onchange'=>'js:mostrarSubproductosReporteAvanceIndicadores(this.value);')
		);

?>
</td>
<td>
<?php
		echo CHtml::dropDownList(
		'Indicadores[subproductoNombre]',""
		,array('0'=>'Seleccione Subproducto')
		,array('id'=>'combo_subproducto','class'=>'selectorIndicadores', 'onchange'=>'js:mostrarProductoEspecificoReporteAvanceIndicadores(this.value);')
		);

?>
</td>
</tr>
<tr>
<td><div  style="float: left">Producto Específico: &nbsp;&nbsp;&nbsp;</div></td>
</tr>
<tr>
<td>
<?php
		echo CHtml::dropDownList(
		'Indicadores[productoEspecificoNombre]',""
		,array('0'=>'Seleccione Producto Específico')
		,array('id'=>'combo_pre_especifico','class'=>'selectorIndicadores')
		);

?>
</td>
<td>

</td>
<td>

</td>
</tr>
<tr>
<td>Instrumento:</td>
<td>
<?php 

$modelins = new Instrumentos();
echo CHtml::activeCheckBoxList($modelins,'nombre',Chtml::listData(Instrumentos::model()->findAll(array('condition'=>'estado = 1')),'id','nombre'), array('separator'=>' ',));
?>

</td>

<td>

</td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td></td>
<td></td>
<td><div style="float:right">
  
<input type="button" value="Filtrar" id="btn" onclick="mostrarReporteAvances()">

 </div></td>
</tr>
</table>
<?php //fin form
//echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();?>
</div>
<div id="grillaDatosReporteIndicadores" style="display:none" class="contenedorGridEjecucionPresupuestaria">
<div style="float:right" id='contenedorExcel'><a id="linkExcel"  name="linkExcel" href="" ><div class="iconoExcel" id ="iconoExcel"></div><div style="float:right">Exportar a MS Excel</div></a></div><div>S.I.: Sin Información</div>
<?php 
$model2 = new Indicadores();
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'id' => 'items-grid',
	'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();circulosRojosReporteAvanceIndicadores();validarAnchoTabla();mostrarBoton();}',
    'pager'=>array('pageSize'=>25),
    'columns'=>array(
		
		array('header'=>'Nº',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
	/*	array(
				'name'=>'id',
				'header'=>'id indicador',
					
		),
		array(
				'name'=>'estrategico',
				'header'=>'id pro estrategico',
			
		),*/
		array(
			'name'=>'divisionNombre',
			'header'=>'C. Responsabilidad',
			
		),
		array(
			'name'=>'centroCostoNombre',
			'header'=>'C.C.',
			
		),
		array(
			'name'=>'cargoNombre',
			'header'=>'Cargo',
			
		),
		array(
			'name'=>'tipoProductoEstrategico',
			'header'=>'Tipo Producto',
			
		),
		array(
			'name'=>'productoEstrategicoNombre',
			'header'=>'P. Estratégico',
			
		),
		array(
			'name'=>'subproductoNombre',
			'header'=>'Subproducto',
		),
			
		array(
			'name'=>'productoEspecificoNombre',
			'header'=>'P. Específico',
		),

		array(
			'name'=>'nombre',
			'header'=>'Indicador',
		),
		array(
		
			'name'=>'instName',
			'header'=>'Instrumento',
            'value'=>array($model2,'obtenerInstrumentosPorColumna'),         
                
		),
		array(
			'name'=>'ponderacion',
			'header'=>'Ponderación',
			'value'=>array($model2, 'obtenerPonderacionPorColumna'),
		),
		array(
			'name'=>'value',
			'header'=>'%',
		),
		
		array(            
            'name'=>'value2',
		 	'header'=>'Estado',
		  	'htmlOptions'=>array('class'=>'graficoProgressbar','style'=>'width: 150px;'),
            'type'=>'html',            
        ),

        array(
            'class' => 'CButtonColumn',
            'template'=>'{view}{comentario}',
            'header' => 'Acción',
            'buttons'=>array(                  
                'comentario'=>
                    array(
                            'url'=>'$this->grid->controller->createUrl("view", array("id_indicador"=>$data["id"],"IndicadoresObservaciones[id_indicador]"=>$data["id"],"IndicadoresObservaciones[bandera]"=>"1"))',
                          //  'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                          	'imageUrl'=>Yii::app()->request->baseUrl.'/images/icono-comentarios.png',
                            'label'=>'Observación',
                            'options'=>array('class'=>'update'),
		        			'visible'=>'Yii::app()->user->checkAccess("supervisor2") && (Yii::app()->user->checkAccessChangeByCentroCostoFromIndicadores(array("modelName"=>"Indicadores","fieldName"=>"productoEspecifico->subproducto->centro_costo_id","idRow"=>$data["id"])) || Yii::app()->user->checkAccessChangeByCentroCostoFromIndicadores(array("modelName"=>"Indicadores","fieldName"=>"lineasAccions[0]->centro_costo_id","idRow"=>$data["id"])))',
                        ),
                'view'=>
                        array(    
                            'label'=>'Detalles',                        
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                            'url'=>'$this->grid->controller->createUrl("update", array("idi"=>$data["id"]))',
                        ),
                            
            ),   
        ),

    ),
));





?>
</div>
