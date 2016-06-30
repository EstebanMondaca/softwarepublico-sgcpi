<?php
/* @var $this DesafiosEstrategicosController */
/* @var $dataProvider CActiveDataProvider */
		    
    $nombreGrilla = 'desafios-estrategicos-grid';

	//Menu agregando el contenido del Año.	
   $this->breadcrumbs=array(    	
	    'Desafíos Estratégicos',
	);
	
?>

<h3><?php echo GxHtml::encode(Yii::t('app', $model->label(1))); ?></h3>

<?php
    
    if(Yii::app()->user->checkAccessChangeDataGore('DesafiosEstrategicosController')){
        /*$this->widget('zii.widgets.CMenu', array(
                'items'=>array(
                        array('label'=>'Agregar Asociación', 'url'=>array('mapaEstrategico/')),
                        array('label'=>'Agregar', 'url'=>array('create')),
                 ),
                 'firstItemCssClass'=>'boton2',
                'htmlOptions'=>array('class'=>'MenuOperations Asociacion'),
        ));*/
        echo '<ul id="yw0" class="MenuOperations Asociacion NoModal">
                    <li class="boton2"><a href="'.Yii::app()->baseUrl.'/mapaEstrategico" class="">Agregar Asociación</a></li>
                    <li><a href="'.Yii::app()->baseUrl.'/desafiosEstrategicos/create" class="update">Agregar</a></li>
                    </ul>';
    }
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
                'template'=>'{view}{update}{delete}',
                'afterDelete'=>'function(link,success,data){if(success)mostrarMensajes(data); }',
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
                          'delete'=>
                            array(
                            	'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
                            	'visible'=>'Yii::app()->user->checkAccessChangeDataGore("DesafiosEstrategicosController",array(),"delete")',
                            ),		
                         
                  ),
            ),
        ),
    )); 
?>




