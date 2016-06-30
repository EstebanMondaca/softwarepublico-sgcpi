<?php

$this->breadcrumbs = array(
	Indicadores::label(2),
	Yii::t('app', 'Index'),
);

$this->menu = array(
	
//	array('label'=>'Agregar ' . Indicadores::label(), 'url' => 'create/1'),
	
	//array('label'=>Yii::t('app', 'Manage') . ' ' . Indicadores::label(2), 'url' => array('admin')),
);
?>

<h3><?php echo GxHtml::encode(Indicadores::label(2)); ?></h3>

<p id='reportarerror' style='color: red;'></p>

	<?php
		echo CHtml::dropDownList(
		'combo1',""
		,array('0'=>'Tipo de Producto')+CHtml::listData($tiposProductos,'id','nombre')
		,array('id'=>'combo1', 'onchange'=>'js:mostrarProductosEstrategicos(this.value);','class'=>'selectorIndicadores')
		);
	?>
	&nbsp;&nbsp;&nbsp;

<!--
Producto Seleccionado.
-->
	
		<?php
			echo CHtml::dropDownList(
			'productoEstrategico',""
			,array('0'=>'Producto Estratégico')
			,array('id'=>'productoEstrategico','onchange'=>'js:mostrarSubProductos(productoEstrategico.value);','class'=>'selectorIndicadores')
			);
		?>
		&nbsp;&nbsp;&nbsp;

<!--
SubProducto .
-->

		<?php
			echo CHtml::dropDownList(
			'subProducto',""
			,array('0'=>'SubProducto')
			,array('id'=>'subProducto','onchange'=>'js:mostrarProductosEspecificos(this.value);','class'=>'selectorIndicadores')
			);
		?>
		&nbsp;&nbsp;&nbsp;
	<!--
Producto Especifico.
-->

		<?php
			echo CHtml::dropDownList(
			'Productos Específicos: ',""
			,array('0'=>'Producto Específico')
			,array('id'=>'productoEspecifico','onchange'=>'js:mostrarIndicadores(this.value);','class'=>'selectorIndicadores')
			);
		
	
		?>
	
		<?php 
		  if(Yii::app()->user->checkAccessByCierre("IndicadoresController") && !(Yii::app()->user->checkAccess("admin")) && (Yii::app()->user->checkAccess("gestor"))){
		      echo '<input style="display: none;" class="boton" type="button" id="btnAgregar" value="Agregar" onclick="createIndicador(productoEspecifico.value)"  name="">';
              echo '</br><label id="labelSubproducto" style="display:none;color: #888;font-size: 11px;">* No es posible crear indicadores bajo el subproducto seleccionado por pertenecer a un centro de costo distinto al de usted.</label>';   
		  } 
		?>
	 	  

 
	<br>
	
<div class="limpia"></div>

 <div id="grillaDatos" style='display: none;'>

	
	<?php 
	
	
	$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'indicadores-grid',
	'dataProvider' => $model->busquedaPersonalizada(),
	'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	//'filter'=>$model,
	'summaryText' => false,
	'columns' => array(
		array(
            'header'=>'N°',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),	
		'nombre',
		'meta_anual',
		array(
            'value'=>'$data->responsable->nombreycargo[0]',
            'header'=>'Responsable'
        ),
	   /* array(            
            'name'=>'columnHiden',
            'header'=>'Accion',
            'type'=>'number',
            //if es necesario cambiar la imagen debe devolver un 1(solo lectura)... de lo contrario un 0(puede editar) 
            //'value'=>'(IndicadoresController::validateAccessbyIndicador($data->id))?0:1',
        
            'headerHtmlOptions'=>array('style'=>'display:none;', 'class'=>'changeImage'),
            'htmlOptions'=>array('style'=>'display:none;', 'class'=>'changeImage'),  
           // 'header'=>false,
           // 'filter'=>false,
        ),*/
		array(
			'class' => 'CButtonColumn',
			//'template'=>'{view} {update} {delete}',
			//'template'=>''.(IndicadoresController::validateAccess())?"{update}":"{delete}",
			//'header' => 'Acción',
			'afterDelete'=>'function(link,success,data){ if(success)mostrarMensajes(data); }',
			'buttons'=>array(
						'view'=>
                            array(                                
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                            	'url'=>'$this->grid->controller->createUrl("view", array("id"=>$data->primaryKey,"idIndicador"=>$data->primaryKey))',
                                'visible'=>'Yii::app()->user->checkAccessChangeDataGore("IndicadoresController",array(),"view")',
                            ),
                        'update'=>
                            array(
                                    'url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey,"idIndicador"=>$data->primaryKey))',
                            		'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                               	  // 'visible'=>'Yii::app()->user->checkAccessChangeDataGore("IndicadoresController",array(),"update")',
                            		 'visible'=>'Yii::app()->user->checkAccessChange(array("modelName"=>"Indicadores","fieldName"=>"responsable_id","idRow"=>$data->id))',
                             		
                            	),
                          'delete'=>
                            array(
                            	'url'=>'$this->grid->controller->createUrl("delete", array("id"=>$data->primaryKey))',
                            	'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
                            	 //'visible'=>'Yii::app()->user->checkAccessChangeDataGore("IndicadoresController",array(),"delete")',
                            	 'visible'=>'Yii::app()->user->checkAccessChange(array("modelName"=>"Indicadores","fieldName"=>"responsable_id","idRow"=>$data->id))',
                            ),	
                  )
		),
	),
)); 
?>
	
</div>




