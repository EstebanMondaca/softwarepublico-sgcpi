<?php

$this->breadcrumbs = array(
    $model->label(2),
);


?>

<h3>Presupuesto por Centro de Costo</h3>


<?php 
   
    $this->widget('ext.groupgridview.GroupGridView', array(
      'id' => 'centro-costo-grid',
      'dataProvider' => $model->busquedaParaPresupuestos(),
      'mergeColumns' => array('nombre_centro_costo','sum_presupuesto_operativo','producto_estrategico','distribucion','acciones'),
      'summaryText' => 'Desplegando {start}-{end} de {count} indicadores.',
      'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
      'columns' => array(
        array(
                'name'=>'nombre_centro_costo',
                'header'=>'Centro de Costo',
                'value'=>'($data->lineasAccions)?$data->lineasAccions[0]->centroCosto:$data->productoEspecifico->subproducto->centroCosto',                
        ),        
        array(    
         'name'=>'sum_presupuesto_operativo',        
         'header'=>'Presupuesto Operativo (OP)',
         'type'=>'raw',
         'value'=>'CHtml::tag("input", array("type"=>"hidden","value"=>($data->lineasAccions)?$data->lineasAccions[0]->centroCosto->id:$data->productoEspecifico->subproducto->centroCosto->id))."$ ".number_format(ProductosItemes::Model()->findBySql(
         
                ($data->lineasAccions)?"SELECT  SUM(pi.monto) AS monto FROM  productos_itemes pi INNER JOIN planificaciones pl ON pi.planificacion_id = pl.id 
                INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id WHERE pp.id = '.Yii::app()->session['idPeriodo'].' AND pi.centro_costo_id=".$data->lineasAccions[0]->centroCosto->id.""
                :
                "SELECT  SUM(pi.monto) AS monto FROM  productos_itemes pi INNER JOIN planificaciones pl ON pi.planificacion_id = pl.id 
                INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id WHERE pp.id = '.Yii::app()->session['idPeriodo'].' AND pi.centro_costo_id=".$data->productoEspecifico->subproducto->centroCosto->id.""
                )->monto,0, "", ".")',           
         //   'value'=>'print_r($data->subproductoses->productoEstrategico)'
        ),
        array(    
         'name'=>'indicadores',        
         'header'=>'Indicadores',
         'value'=>'$data->nombre'
        ),
        array(    
         'name'=>'producto_estrategico',        
         'header'=>'Producto Estratégico',
         'value'=>'($data->lineasAccions)?$data->lineasAccions[0]->productoEstrategico:$data->productoEspecifico->subproducto->productoEstrategico',           
        ),
        array(    
         'name'=>'distribucion',        
         'header'=>'% Distrib.',
         'type'=>'raw',
         'value'=>'CHtml::tag("input", array("type"=>"hidden","value"=>($data->lineasAccions)?$data->lineasAccions[0]->productoEstrategico->id:$data->productoEspecifico->subproducto->productoEstrategico->id))." ".$data->centroCostoPorcentaje',           
        ),     //
      //'.'$this->grid->controller->createUrl("view", array("id"=>$data->productoEspecifico->subproducto->centroCosto->primaryKey))'.'  
        array(            
            'name'=>'columnHiden',
            'header'=>'Producto Estrátegico',
            'type'=>'number',
            //if es necesario cambiar la imagen debe devolver un 1(solo lectura)... de lo contrario un 0(puede editar) 
            'value'=>'',//'(ActividadesController::validateAccessbyIndicador($data->id))?0:1',
            //'value'=>'',            
            'headerHtmlOptions'=>array('style'=>'display:none;', 'class'=>'changeImage'),
            'htmlOptions'=>array('style'=>'display:none;', 'class'=>'changeImage'),  
           // 'header'=>false,
           // 'filter'=>false,
        ),
         array(
                'name'=>'acciones',
                'header'=>'Acción',
                'type'=>'raw',              
                'value'=> ' CHtml::link(CHtml::image("'.Yii::app()->request->baseUrl.'/images/view.png"), $this->grid->controller->createUrl("view", array("id"=>($data->lineasAccions)?$data->lineasAccions[0]->centroCosto->id:$data->productoEspecifico->subproducto->centroCosto->id)), array("class"=>"update"))."".
                            CHtml::link(CHtml::image("'.Yii::app()->request->baseUrl.'/images/edit.png"), $this->grid->controller->createUrl("update", array("id"=>($data->lineasAccions)?$data->lineasAccions[0]->centroCosto->id:$data->productoEspecifico->subproducto->centroCosto->id)), array("class"=>"update"))
                           ',             
                'visible'=>(Yii::app()->user->checkAccess("admin"))?true:false,
        ),
        array(
                'name'=>'acciones',
                'header'=>'Acción',
                'type'=>'raw',              
                'value'=> 'CHtml::link(CHtml::image("'.Yii::app()->request->baseUrl.'/images/view.png"), $this->grid->controller->createUrl("view", array("id"=>($data->lineasAccions)?$data->lineasAccions[0]->centroCosto->id:$data->productoEspecifico->subproducto->centroCosto->id)), array("class"=>"update"))',             
                'visible'=>(Yii::app()->user->checkAccess("admin"))?false:true,
        ),
      ),
    ));
 /*$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'actividades-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
                'name'=>'indicador_id',
                'value'=>'GxHtml::valueEx($data->indicador)',
                'filter'=>GxHtml::listDataEx(Indicadores::model()->findAllAttributes(null, true)),
                ),
        'nombre',
        'verificacion',
        'cantidad',
        'estado',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); */?>