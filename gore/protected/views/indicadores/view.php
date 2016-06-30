<div class="form">
<?php if($producto_especificoN!=""){?>
    <h3>Vista del indicador de desempeño Asociado a un <?php echo $tipoProducto->descripcion ?></h3>
    <br>
    <div> Producto Estratégico :  <b>  <?php echo $nombreProductoEstrategico; ?> </b></div>
    <div>Subproducto :  <b> <?php echo $nombreSubproducto; ?> </b></div>
    <div>Producto Específico : <b> <?php echo $producto_especificoN; ?></b></div>
<?php }else{
    echo "<h3></h3>";
    echo "<div>Producto Estratégico:  <b>".$nombreProductoEstrategico."</b></div>";
         if($model->lineasAccions)
            echo "<div>AMI o LA:  <b>".$model->lineasAccions[0]->nombre."</b></div>";
}?>
<br>
<div class="limpia"></div>

<?php 
$periodoActual = Yii::app()->session['idPeriodoSelecionado'];
$t1 = $periodoActual-1;
$t2 = $periodoActual-2;
$t3 = $periodoActual-3;

$nombret1 = 'Meta Año t-1 '.' ('.$t1.')';
$nombret2 = 'Efectivo Año t-2 '.' ('.$t2.')';
$nombret3 = 'Efectivo Año t-3 '.' ('.$t3.')';


	 $htmlHitos= "<ul>";
	 $modelo = $model->hitosIndicadores;
	foreach($modelo as $relatedModel) {
		$htmlHitos = $htmlHitos. "<li>".$relatedModel. " = " . $relatedModel->meta_parcial ."</li>";
	}
	$htmlHitos =$htmlHitos. "</ul>";
	



$this->widget('ext.widgets.DetailView4Col', array(
    'data'=>$model,
    'attributes'=>array(
	 	//	HEADER	
        array(
            'header'=>'Indicador de Desempeño',
        ),
        array(
            'name'=>'nombre',
            'oneRow'=>true,
        ),
        array(
            'name'=>'descripcion',
            'oneRow'=>true,
        ),
         //	HEADER
    	array(
            'header'=>'Asignación Responsabilidad Interna',
        ),
       	array(
            'name'=>'Centro de Responsabilidad',
       		'value'=>$centroResponsabilidad,
        ),
        array(
          'name'=>'responsable_id',
          'type'=>'raw',
          'value'=> IndicadoresController::obtenerNombreUsuario($model->responsable_id),
         
        ),
        array(
            'name'=>'Centro de Costo',
       		'value'=>$centroCosto,
        ),
        //	HEADER
        array(
            'header'=>'Clasificación',
        ),
        array(
            'name'=>'asociacion_id',
       		'value'=>$model->asociacion_id== 1 ? "Si":"No",
        ),
       /* array(
            'label'=>'Desagregado Por Sexo',
       		//'value'=>$model->desagregado== 1 ? "Si":"No",
        ),        
        array(
            'label'=>'Gestion Territorial',
       		//'value'=>$model->gestion_territorial== 1 ? "Si":"No",
        ),          
        */
        array(
				'name' => 'clasificacionAmbito',
				'type' => 'raw',
				'value' => $model->clasificacionAmbito,
		),
		array(
				'name' => 'clasificacionDimension',
				'type' => 'raw',
				'value' => $model->clasificacionDimension ,
		),
		array(
				'label' => 'Tipo',
				'value' => $model->clasificacionTipo,
		),
		//	HEADER
        array(
            'header'=>'Fórmula',
        ),
       	array(
			'name' => 'unidad',
			'type' => 'raw',
			'value' => $model->unidad,
		),		
		array(
            'name' => 'ascendente',
            'type' => 'raw',
            'value' => $model->ascendente == 1 ? "Si":"No",
        ),
        array(
			'name' => 'tipoFormula',
			'type' => 'raw',
        	'oneRow'=>true,
			'value' => $model->tipoFormula,
		),
		'conceptoa',
		'conceptob',
		'conceptoc',
		//	HEADER
        array(
            'header'=>'Descripción Fórmula y Medios de Verificación',
        ),
       	array(
			'name' => 'formula',
			'type' => 'raw',
       		'oneRow'=>true,
			'value' => $model->formula,
		),	
       	array(
			'name' => 'medio_verificacion',
			'type' => 'raw',
       		'oneRow'=>true,
			'value' => $model->medio_verificacion,
		),	
       	array(
			'name' => 'notas',
			'type' => 'raw',
       		'oneRow'=>true,
			'value' => $model->notas,
		),
		//	HEADER
        array(
            'header'=>'Resultados Históricos del Indicador ',
        ),	
        array(
			'label' => $nombret3,
			'value' => $model->efectivot3,
		),
        array(
			'label' => $nombret2,
			'value' => $model->efectivot2,
		),		
        array(
			'label' => $nombret1,
			'value' => $model->efectivot1,
		),	
		//	HEADER			
		 array(
            'header'=>'Metas año t ( '.$periodoActual.' )',
        ),	
        'meta_anual',
        array(
			'label' => 'frecuencia de Control',
			'value' => $model->frecuenciaControl,
		),
		array(
			'label' => 'Frecuencias',
			'type' => 'raw',
			'value' => $htmlHitos,
		),	
		//	HEADER			
		 array(
            'header'=>'Supuestos',
        ),	
        array(
			'name' => 'supuestos',
       		'oneRow'=>true,
			'value' => $model->supuestos,
		),
    )
));


?>


</div>