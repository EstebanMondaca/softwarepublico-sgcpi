<div class="form">
<h3 rel="<?php echo $title ?>"><?php echo $nombre?></h3>
S.I.: Sin Información.
<?php
Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerCssFile(
Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerScript('init', "
    	
    	graficoProgressbar();
    	validarAnchoTabla();
",'3');


$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
	'afterAjaxUpdate'=>'function(id, data){parent.afterAjaxUpdateSuccess();graficoProgressbar();validarAnchoTabla();}',
	'columns'=>array(	
		/*array(
			'name'=>'id',
			'header'=>'id indicador',
		
		
		),	*/
		array('header'=>'Nº',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
			
		array(
			'name'=>'subp_nombre',
			'header'=>'Sub Producto',
		
		
		),
		
		array(
			'name'=>'pro_especifico_nom',
			'header'=>'Producto Específico',
		
		
		),
		array(
			'name'=>'nombre',
			'header'=>'Indicador',
	
		
		),
		array(
			'name'=>'fecha',
			'header'=>'Fecha',
		
		
		),
		 array(            
            'name'=>'value',
		 	'header'=>'Avance a la Fecha',
		  	'htmlOptions'=>array('class'=>'graficoProgressbar','style'=>'width: 150px;'),
            'type'=>'html',            
        ),
		array(
			'name'=>'esperado',
			'header'=>'Avance Esperado',
		
		
		),
		array(
			'header'=>'Responsable',
		    'name'=> 'nombreResponsable',
		),

		array(
			'name'=>'frecuencia',
			'header'=>'Frecuencia Control',
		),


	),

));





?>
</div>