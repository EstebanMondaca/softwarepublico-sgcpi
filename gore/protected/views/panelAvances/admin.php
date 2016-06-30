<h3>Indicadores Bajo su Responsabilidad</h3>
<?php
date_default_timezone_set("America/Santiago");
$anio = date("Y");

if(Yii::app()->session['idPeriodoSelecionado']==$anio){
$direccionImagen = '/images/edit.png';
$label='Editar';
}else{
$label='Detalles';
$direccionImagen ='/images/icono_lupa.png';
}
Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerCssFile(
Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerScript('init', "
    	graficoProgressBar();
    	validarAnchoTabla();
    	
");

$this->breadcrumbs = array(

Yii::t('ui','Panel General de Avance')=>array('/panelAvances'),
Yii::t('app', 'Indicadores'),
);
?>
<div>S.I.: Sin Información.</div>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
	'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();graficoProgressBar();validarAnchoTabla();}',
	'columns'=>array(


		array('header'=>'N°',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        

		array(
			'name'=>'p_estra_nom',
			'header'=>'Producto Estratégico Asociado',
			
		
		),
		
		array(
			'name'=>'nom_indicador',
			'header'=>'Indicador',
			
		
		),
		array(
			'name'=>'fecha',
			'header'=>'Fecha',
			
		
		),
		 array(            
            'name'=>'value',
		 	'header'=>'Avance a la Fecha',
		  	'htmlOptions'=>array('class'=>'graficoProgressbar'),
            'type'=>'html',            
        ),
		array(
			'name'=>'esperado',
			'header'=>'Avance Esperado',
		
		
		),
	
				array(
			'name'=>'frecuencia',
			'header'=>'Frecuencia Control',
		),
				array(
			'name'=>'ascendente1',
			'header'=>'Comportamiento',
		),
	

		array(
			'class' => 'CButtonColumn',
			'template'=>'{update}{view}',
			'updateButtonOptions'=>array('class'=>''), 
			'buttons'=>array(
    		 'update' => array
    		        (
    				'label'=> $label,
    				'url'=>'$this->grid->controller->createUrl("update", array("idi"=>$data["id"]))',
    				'imageUrl'=>Yii::app()->request->baseUrl.$direccionImagen,
    				'visible'=>'(Yii::app()->user->checkAccessChange(array("modelName"=>"Indicadores","fieldName"=>"responsable_id","idRow"=>$data["id"])))||(Yii::app()->user->checkAccessChange(array("modelName"=>"HitosIndicadores","fieldName"=>"idIndicador->responsable_id","idRow"=>$data["id"])))',
    				),    			
    		'view' => array
                    (
                    'label'=> $label,
                    'url'=>'$this->grid->controller->createUrl("verComentarios", array("id_indicador"=>$data["id"]))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/icono-comentarios.png',
                    'visible'=>'isset($data["observaciones"])',
                    ),
                ),
		),

        
        



	),
));

?>