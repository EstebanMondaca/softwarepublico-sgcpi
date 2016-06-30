<?php

$this->breadcrumbs = array(
    Yii::t('app', $model->label(2))
);

?>

<h3>Objetivos Estratégicos</h3>


<?php 
if(Yii::app()->user->checkAccessChangeDataGore('ObjetivosEstrategicosController')){
    $this->widget('zii.widgets.CMenu', array(
                'items'=>array(array('label'=>'Agregar', 'url'=>array('create'))),
                'htmlOptions'=>array('class'=>'MenuOperations'),
    ));
}

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'objetivos-estrategicos-grid',
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
    'columns' => array(
        array(
            'header'=>'N°',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        array(
              'name'=>'nombre',
              'htmlOptions'=>array('width'=>'550'),
            ),
        array(
                'name'=>'perspectiva_estrategica_id',
                'value'=>'GxHtml::valueEx($data->perspectivaEstrategica)',
                'filter'=>GxHtml::listDataEx(PerspectivasEstrategicas::model()->findAll(array('condition'=>'estado=1'))),
                
                ),
        array(
            'class' => 'CButtonColumn',
            'header'=>'Acciones',
            'afterDelete'=>'function(link,success,data){if(success)mostrarMensajes(data); }',
        	'buttons'=>array(
                        'update'=>
                            array(
                            		'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png', 
                            		'visible'=>'Yii::app()->user->checkAccessChangeDataGore("ObjetivosEstrategicosController",array(),"update")',                         		
                            	),
                          'delete'=>
                            array(
                            	'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
                            	'visible'=>'Yii::app()->user->checkAccessChangeDataGore("ObjetivosEstrategicosController",array(),"delete")',
                            ),
                          'view'=>
                            array(                                
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                                'visible'=>'Yii::app()->user->checkAccessChangeDataGore("ObjetivosEstrategicosController",array(),"view")',
                            ),		
              ),
        ),
    ),
)); ?>