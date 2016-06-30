<?php
/* @var $this DesafiosEstrategicosController */
/* @var $dataProvider CActiveDataProvider */
		    
    $nombreGrilla = 'desafios-estrategicos-grid';

	//Menu agregando el contenido del Año.	
   $this->breadcrumbs=array(
        'Desafíos Estratégicos'=>Yii::app()->baseUrl.'/desafiosEstrategicos/',    	
	    'Asociación de Desafíos Estratégicos',
	);
	
?>

<h3>Asociación de Desafíos Estratégicos</h3>

<?php
    
	$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>$nombreGrilla,
        'dataProvider'=>$model->search(),
        //'filter'=>$model,
        'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
        'columns'=>array(
            array(
            'header'=>'N°',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            array(
              'name'=>'nombre',              
             'value'=>'$data->nombre',
             'htmlOptions'=>array('width'=>'550px'),
            ),
                array(
                'name'=>'perspectiva_estrategica_id',
                'value'=>'GxHtml::valueEx($data->perspectivaEstrategica)',
                'filter'=>GxHtml::listDataEx(PerspectivasEstrategicas::model()->findAll(array('condition'=>'estado=1'))),
                ),
            
            array(
                'class'=>'CButtonColumn',
                'header'=>'Acciones',
                'template'=>'{view}{update}',
            	'buttons'=>array(      
        	       'view'=>
                        array(                                
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                            'visible'=>'Yii::app()->user->checkAccessChangeDataGore("DesafiosEstrategicosController",array(),"view")',
                        ),      	
                    'update'=>
                        array(
                                'url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey))',
                        		'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                         		'visible'=>'Yii::app()->user->checkAccessChangeDataGore("DesafiosEstrategicosController",array(),"update")',
                        	),                         
                  ),
            ),
        ),
    )); 
?>




