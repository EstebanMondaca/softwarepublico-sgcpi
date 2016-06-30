<?php

$this->breadcrumbs = array(
	Yii::t('ui','Preferencias')=>array('/site/preferencias'),	
	Yii::t('app', $model->label(2)));

$this->menu = array(
		array('label'=>Yii::t('app', 'Agregar'), 'url'=>array('create')),
	);
?>
<div class="form">
<h3><?php echo GxHtml::encode($model->label(2)); ?></h3>

<div id='criterios' style='float:left;'>
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

<div id="grillaDatos" style='display:none;'>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'elementos-gestion-grid',
	'dataProvider' => $model->searchResponsable(),
	'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	'columns' => array(
		'nombre',
		array(
                'header'=>'Puntaje Actual',
                'name'=>'puntaje_actual',
                'value'=>'$data->ultimoPuntajeActual',
                'htmlOptions'=>array('width'=>'90','class'=>'puntaje_actual'),
             ),
		array(
                'name'=>'elementosGestionPriorizadoses',
                'header'=>'Priorizado',
                'value'=>'($data->elementosGestionPriorizadoses)?"Si":"No"',
        ),       
        array(
                'name'=>'input',
                'type'=>'raw',
                'header'=>'Marcadores',
                'value'=>'CHtml::checkBox("Marcadores".$row, (isset($_GET["el"]))?(in_array($data->id,$_GET["el"]))?true:false:false,array("value"=>$data->id,"title"=>(isset($data->laElemGestions2[0]))?(isset($_GET["idLA"]))?($data->laElemGestions2[0]->id_la!=$_GET["idLA"])?"El presente elemento de gestión ya fue seleccionado por otra AMI/LA":"":"":"","disabled"=>(isset($data->laElemGestions2[0]))?(isset($_GET["idLA"]))?($data->laElemGestions2[0]->id_la!=$_GET["idLA"])?true:false:false:false,"onclick"=>"agregarElementoGestionAsociadoLA(this,$data->id,\'$data->n_elementogestion\',$data->ultimoPuntajeActual,\'$data->puntajeElemento\')"))',                
        ), 		
	),
)); ?>
</div>