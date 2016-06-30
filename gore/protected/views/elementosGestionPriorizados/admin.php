<?php

$this->breadcrumbs = array(
	'Elementos de Gestión'
);

/*$this->menu = array(
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	);
*/
Yii::app()->clientScript->registerScript('search', "
$('#tabs').tabs();
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('elementos-gestion-priorizados-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<h3>Elementos de Gestión</h3>

<div id="tabs">
    <ul>
        <li><a href="#tabs1">Áreas de Mejora de la Gestión</a></li>
        <li><a href="#tabs2">Asociación Elemento de gestión con Responsable</a></li>
    </ul>
        <div id="tabs1">
            <h3><b>Áreas de Mejora de la Gestión:</b> <i>Criterios, Sub-criterios y Elementos de Gestión Priorizados </i></h3>
            <br/>
            <?php
                if(Yii::app()->user->checkAccessChangeDataGore('ElementosGestionPriorizadosController')){ ?>
                <div class="fieldset2">
                    <div class="legend">Agregar Elementos de Gestión</div>
                        <div class="content"> 
                        <br>
                        <!--
                        Criterio
                        -->
                                <?php
                                    echo CHtml::dropDownList(
                                    'criterio',""
                                    ,array('0'=>'Seleccione Criterio')+CHtml::listData($criterios,'id','nombre')
                                    ,array('id'=>'criterio','onchange'=>'js:mostrarSubCriterios(criterio.value);')
                                    );
                
                                ?>
                            &nbsp;&nbsp;&nbsp;
                
                        <!--
                        SubCriterio .
                        -->
                            
                        
                                <?php
                                    echo CHtml::dropDownList(
                                    'subcriterio',""
                                    ,array('0'=>'Seleccione SubCriterio')
                                    ,array('id'=>'subcriterio','onchange'=>'js:mostrarElementosDeGestion(this.value);')
                                    );
                                ?>
                        &nbsp;&nbsp;&nbsp;
                    
                            <!--
                        Elemento Gestion.
                        -->
                            
                            
                                <?php
                                    echo CHtml::dropDownList(
                                    'elementoGestion: ',""
                                    ,array('0'=>'Seleccione Elemento de Gestión')
                                    ,array('id'=>'elementoGestion')
                                    );
                                ?>
                                
                            &nbsp;&nbsp;&nbsp;  
                            
                                <input type="button" value="Agregar" name="yt1" onclick="agregarElementodeGestion(<?php echo Yii::app()->session['idPeriodoSelecionado'] ?>,elementoGestion.value)">
                            
                        
                        </div>
                    </div>  
                <?php }//end if checkAccessChangeDataGore?>
                
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'elementos-gestion-priorizados-grid',
                    'dataProvider' => $model->search(),
                    'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
                    //'filter' => $model,
                    'columns' => array(
                        array('header'=>'N°',
                            'htmlOptions'=>array('width'=>'30'),
                            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        ),
                        array(
                                'header'=>'Criterio',
                                'value'=> 'GxHtml::valueEx($data->idElementoGestion->idSubcriterio->idCriterio)',
                                
                        ),  
                        array(
                                'header'=>'Sub-criterio',
                                'value'=> 'GxHtml::valueEx($data->idElementoGestion->idSubcriterio)',
                                
                                ),
                    
                        /*array(
                                'name'=>'id_planificacion',
                                'value'=>'GxHtml::valueEx($data->idPlanificacion)',
                                'filter'=>GxHtml::listDataEx(Planificaciones::model()->findAllAttributes(null, true)),
                                ),*/        
                        array(
                                'name'=>'id_elemento_gestion',
                                'value'=>'GxHtml::valueEx($data->idElementoGestion)',
                                'filter'=>GxHtml::listDataEx(ElementosGestion::model()->findAllAttributes(null, true)),
                                ),      
                        array(
                            'header'=>'Acciones',
                            'class' => 'CButtonColumn',
                            'template' => '{delete}',
                            'afterDelete'=>'function(link,success,data){ if(success) mostrarMensajes(data); }',
                            'buttons'=>array(
                                          'delete'=>
                                            array(
                                                'url'=>'$this->grid->controller->createUrl("delete", array("id"=>$data->primaryKey,"idIndicador"=>$data->primaryKey))',
                                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
                                                'visible'=>'Yii::app()->user->checkAccessChangeDataGore("ElementosGestionPriorizadosController",array(),"delete")',
                                            )
                                  )
                        ),
                    ),
                    //'afterAjaxUpdate' => "function(id, options) { afterAjaxUpdate(id, options); }",
                )); ?>
        </div>
        <div id="tabs2">
            <h3>Asociación de elementos de gestión con sus respectivos responsables.</h3>
            <br/>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'elementos-gestion-responsables',
                    'dataProvider' => $modelElementosGestion->search(),
                    'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
                     //'filter' => $model,
                    'columns' => array(                        
                        array('header'=>'N°',
                            'htmlOptions'=>array('width'=>'30'),
                            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        ),
                        array(
                                'header'=>'Criterio',
                                'value'=> 'GxHtml::valueEx($data->idSubcriterio->idCriterio)',
                                
                        ),  
                        array(
                                'header'=>'Sub-criterio',
                                'value'=> 'GxHtml::valueEx($data->idSubcriterio)',
                                
                                ),
                        array(
                                'header'=>'Elemento de Gestión',
                                //'name'=>'nombre',
                                'value'=>'GxHtml::valueEx($data)',
                                //'filter'=>GxHtml::listDataEx(ElementosGestion::model()->findAllAttributes(null, true)),
                                ),
                         array(                                
                                'name'=>'responsable',
                                'value'=>'(isset($data->elementosGestionResponsables[0]))?$data->elementosGestionResponsables[0]->responsable->username:""',                                
                                ),      
                        array(
                            'header'=>'Acciones',
                            'class' => 'CButtonColumn',
                            'template' => '{update}{create}',
                            'afterDelete'=>'function(link,success,data){ if(success) mostrarMensajes(data); }',
                            'buttons'=>array(
                                          'update'=>
                                            array(
                                                'url'=>'$this->grid->controller->createUrl("/elementosGestionResponsable/update/", array("id"=>(isset($data->elementosGestionResponsables[0]))?$data->elementosGestionResponsables[0]->id:""))',
                                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',                                                
                                                //'visible'=>'(isset($data->elementosGestionResponsables[0]))',
                                                'visible'=>'(Yii::app()->user->checkAccessChangeDataGore("ElementosGestionResponsableController",array(),"update")) && (isset($data->elementosGestionResponsables[0]))',
                                            ),
                                            'create'=>
                                                array(
                                                    'url'=>'$this->grid->controller->createUrl("/elementosGestionResponsable/create/", array("id"=>$data->id))',
                                                    'options'=>array(                                                
                                                       'class'=>'update',                                                                                                                                     
                                                    ),
                                                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                                                    //'visible'=>'(!isset($data->elementosGestionResponsables[0]))',
                                                    'visible'=>'Yii::app()->user->checkAccessChangeDataGore("ElementosGestionResponsableController",array(),"create") && (!isset($data->elementosGestionResponsables[0]))',
                                                )
                                  )
                        ),
                    )
                    //'afterAjaxUpdate' => "function(id, options) { afterAjaxUpdate(id, options); }",
                )); ?>
        </div>
</div>


