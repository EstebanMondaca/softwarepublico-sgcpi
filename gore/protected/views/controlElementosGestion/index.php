<?php

$this->breadcrumbs = array(	
	'Selección elemento gestión');

?>

<h3>Selección elemento gestión</h3>

<div id='criterios' style='float:left;width: 400px;'>
	<span>Criterios:</span>

	<?php
		echo CHtml::dropDownList(
		'criterios',""
		,array('0'=>'Seleccione Criterio')+CHtml::listData($criterios,'id','nombre')
		,array('id'=>'criterio','onchange'=>'js:mostrarSubCriterios(criterio.value);')
		);
	?>
</div>
<div id='siguiente' style='float:right:;'>
	<span>Subcriterios:</span>
	<?php
		echo CHtml::dropDownList(
		'subcriterio',""
		,array('0'=>'Seleccione SubCriterio')
		,array('id'=>'subcriterio','onchange'=>'mostrarElementosdeGestion2(criterio.value,subcriterio.value);')
		);
	?>
</div>
<div class="limpia"></div>
<div id="grillaDatos" style='display:none;'>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'elementos-gestion-grid',
	'dataProvider' => $model->searchControl(),
	'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	'columns' => array(
	   array('header'=>'N°',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
		array(
				'name'=>'id_criterio',
				'header'=>'Criterio',
				'htmlOptions'=>array('width'=>'100'),
				'value'=>'$data->idSubcriterio->idCriterio'
             ),
        array(
                'name'=>'id_subcriterio',
                'header'=>'SubCriterio',
                'htmlOptions'=>array('width'=>'150'),
                'value'=>'$data->idSubcriterio'
             ),
        array(
                'name'=>'nombre',
                'header'=>'Elemento de Gestión',
                'value'=>'$data->nombre'
             ),	
		array(
			'class' => 'CButtonColumn',
			'template'=>'{view}{update}',
			//'updateButtonOptions'=>array('class'=>''), 
			'header'=>'Acciones',
			'buttons'=>array(
			             'update'=>	array(
			                     'url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey))',
							     'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
							     'visible'=>'Yii::app()->user->checkAccessChangeFromElementosDeGestionSegunCC(array("modelName"=>"ElementosGestion","from"=>"controlElementosGestion","idRow"=>$data->id))',
                                 ),	
                         'view'=>
                            array(    
                                'url'=>'$this->grid->controller->createUrl("view", array("id"=>$data->id))',                            
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                                'visible'=>'Yii::app()->user->checkAccessChangeDataGore("ControlElementosGestionController",array(),"view")',
                            ),						
			     ),			
		),
	),
)); ?>

</div>