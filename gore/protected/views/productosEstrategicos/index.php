<?php

$this->breadcrumbs = array(
    'Producto Estratégico '.$tipoProducto,
);



 echo "<h3>".GxHtml::encode('Producto Estratégico '.$tipoProducto)."</h3>"; 
 if(Yii::app()->user->checkAccessChangeDataGore('ProductosEstrategicosController')){
     $this->widget('zii.widgets.CMenu', array(
                    'items'=>array(array('label'=>'Agregar', 'url'=>array('create', 'tipoProducto'=>$tipo_producto_id))),
                    'htmlOptions'=>array('class'=>'MenuOperations'),
                ));
 }

  $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'productos-estrategicos-grid',
    'dataProvider' => $model->search(),
    'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
    //'filter' => $model,
    'columns' => array(
            array('header'=>'N°',
                'htmlOptions'=>array('width'=>'30'),
                'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            array(  
                'name'=>'nombre',
                'value'=>'$data->nombre',                        
            ),
            array(  
                'name'=>'descripcion',
                'value'=>'$data->descripcion',                        
            ),
        array(
            'class' => 'CButtonColumn',
            'template'=>'{view}{update}{delete}{subproducto}',
            'afterDelete'=>'function(link,success,data){if(success)mostrarMensajes(data); }',
            'header' => 'Acciones',
            'buttons'=>array(
                        'view'=>
                            array(    
                                'url'=>'$this->grid->controller->createUrl("ver", array("id"=>$data->primaryKey))',                            
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                                'visible'=>'Yii::app()->user->checkAccessChangeDataGore("ProductosEstrategicosController",array(),"view")',
                            ),
                        'update'=>
                            array(
                                    'url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey,"tipoProducto"=>'.$tipo_producto_id.'))',
                                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',    
                                    'visible'=>'Yii::app()->user->checkAccessChangeDataGore("ProductosEstrategicosController",array(),"update")',                            
                                ),
                          'delete'=>
                            array(
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',    
                                'visible'=>'Yii::app()->user->checkAccessChangeDataGore("ProductosEstrategicosController",array(),"delete")',                            
                            ),                          
                         'subproducto' => 
                            array(
                                'label'=>'Ver/Modificar Subproducto',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/viewModal.png',
                                'url'=>'Yii::app()->request->baseUrl."/Subproductos/".$data->id',     
                         ),
            ),
                            
                        
                        
        ),
    ),
)); ?>