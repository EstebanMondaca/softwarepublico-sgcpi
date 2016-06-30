<?php

$this->breadcrumbs = array(
    $model->label(2)
);


echo "<h3>".GxHtml::encode('Definición de Líneas de Acción y AMI')."</h3>"; 

if(!Yii::app()->user->checkAccess('admin') && (Yii::app()->user->checkAccess("gestor")) && Yii::app()->user->checkAccessByCierre("LineasAccionController")){//Yii::app()->user->checkAccessChangeDataGore('LineasAccionController')){
    $this->widget('zii.widgets.CMenu', array(
                    'items'=>array(array('label'=>'Agregar', 'url'=>array('create'))),
                    'htmlOptions'=>array('class'=>'MenuOperations NoModal'),
    ));
}
            
?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'lineas-accion-grid',
    'dataProvider' => $model->search(),
    'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
    'columns' => array(
        array('header'=>'N°',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        array(
            'name'=>'nombre',
            'htmlOptions'=>array('width'=>'670'),
            'value'=>'$data->nombre',
            'header'=>'Líneas de Acción(LA) / Acciones de Mejora Inmediata(AMI)'
            ),
        array(
                'name'=>'id_tipo_la',
                'value'=>'$data->idTipoLa',
                'header'=>'Tipo',
                //'filter'=>GxHtml::listDataEx(TiposLa::model()->findAllAttributes(null, true)),
             ),
        
        array(
            'class' => 'CButtonColumn',           
            'template'=>'{view}{update}{delete}',
            'updateButtonOptions'=>array('class'=>''),
            'viewButtonOptions'=>array('class'=>''), 
            'header'=>'Acciones',
            'afterDelete'=>'function(link,success,data){ if(success)mostrarMensajes(data); }',
            'buttons'=>array(
                        'view'=>
                            array(    
                                'url'=>'$this->grid->controller->createUrl("view", array("id"=>$data->primaryKey))',                            
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                                'visible'=>'Yii::app()->user->checkAccessChangeDataGore("LineasAccionController",array(),"view")',
                            ), 
                        'update'=>
                            array(
                                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png', 
                                    'visible'=>'Yii::app()->user->checkAccessChangeDataGore("LineasAccionController",array("modelName"=>"LineasAccion","fieldName"=>array("id_responsable_mantencion","id_responsable_implementacion"),"idRow"=>$data->primaryKey),"update") || (Yii::app()->user->checkAccess("admin"))',                                                                      
                                ),
                          'delete'=>
                            array(
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',       
                                'visible'=>'Yii::app()->user->checkAccessChangeDataGore("LineasAccionController",array("modelName"=>"LineasAccion","fieldName"=>array("id_responsable_mantencion","id_responsable_implementacion"),"idRow"=>$data->primaryKey),"delete") || (Yii::app()->user->checkAccess("admin"))',                       
                           ),      
                  ),
        ),
    ),
)); ?>