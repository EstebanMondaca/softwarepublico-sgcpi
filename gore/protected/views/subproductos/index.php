<?php

$this->breadcrumbs = array(
    'Productos Estratégicos '.$model->productoEstrategico->tipoProducto=>Yii::app()->request->baseUrl."/productosEstrategicos/".$model->productoEstrategico->tipo_producto_id, //productosEstrategicos   
	Yii::t('app', $model->label(1)),
);

?>

<h3><?php echo GxHtml::encode($model->label(1)." de ".$model->productoEstrategico); ?></h3>



<?php 
if(Yii::app()->user->checkAccessChangeDataGore('SubproductosController')){
    $this->widget('zii.widgets.CMenu', array(
                    'items'=>array(array('label'=>Yii::t('app', 'Agregar'), 'url'=>array('create', 'productoEstrategico'=>$model->producto_estrategico_id,'division'=>$model->productoEstrategico->division->id))),
                    'htmlOptions'=>array('class'=>'MenuOperations'),
        ));
}
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'subproductos-grid',
	'dataProvider' => $model->search(),
	'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	//'filter' => $model,
	'columns' => array(
		array(
            'header'=>'N°',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
		'nombre',
		//'descripcion',
		array(
                'name'=>'centro_costo_id',
                'value'=>'GxHtml::valueEx($data->centroCosto)',
                'filter'=>GxHtml::listDataEx(CentrosCostos::model()->findAll(array('condition'=>'estado=1'))),
                'htmlOptions'=>array('width'=>'300'),
                ),
		//'estado',
		array(
			'class' => 'CButtonColumn',
			'afterDelete'=>'function(link,success,data){ if(success)mostrarMensajes(data); }',
			'header'=>'acciones',
			'buttons'=>array(
			             'view'=>
                            array(    
                                'url'=>'$this->grid->controller->createUrl("ver", array("id"=>$data->primaryKey))',                            
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                                'visible'=>'Yii::app()->user->checkAccessChangeDataGore("DesafiosEstrategicosController",array(),"view")',
                            ), 
                        'update'=>
                            array(
                                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                                    'visible'=>'Yii::app()->user->checkAccessChangeDataGore("DesafiosEstrategicosController",array(),"update")',
                                ),
                          'delete'=>
                            array(
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',  
                                'visible'=>'Yii::app()->user->checkAccessChangeDataGore("DesafiosEstrategicosController",array(),"delete")',                            
                            ),      
                  ),
		),
	),
)); ?>