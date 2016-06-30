<?php

$this->breadcrumbs = array(
    $model->label(2),
);


?>

<h3>Planificación de actividades por indicador</h3>


<?php 
    $idPlanificacion = Planificaciones::model()->findAll(array('condition'=>'pp.id='.Yii::app()->session['idPeriodo'], 'join'=>'join periodos_procesos pp on t.periodo_proceso_id=pp.id')); 
    $idPlanificacion=$idPlanificacion[0]->id;
    $this->widget('ext.groupgridview.GroupGridView', array(
      'id' => 'actividades-grid',
      'dataProvider' => $model->busquedaParaActividades(),
      'mergeColumns' => array('nombre_productoEstrategico','sum_presupuesto_operativo','sum_presupuesto_funcionamiento'),
      'summaryText' => 'Desplegando {start}-{end} de {count} indicadores.',
      'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
      'columns' => array(
        array(
                'name'=>'nombre_productoEstrategico',
                'header'=>'Producto Estrátegico',
                'value'=>'($data->lineasAccions)?$data->lineasAccions[0]->productoEstrategico:$data->productoEspecifico->subproducto->productoEstrategico',
                'filter'=>GxHtml::listDataEx(ProductosEstrategicos::model()->findAll(array('condition'=>'estado=1'))),
                'sortable'=>TRUE,
        ),   //($data->lineasAccions[0])?$data->lineasAccions[0]->productoEstrategico->id:$data->productoEspecifico->subproducto->productoEstrategico->id     
        array(    
         'name'=>'sum_presupuesto_operativo',        
         'header'=>'Presupuesto Operativo (PO)',
         'type'=>'raw',
         'value'=>'CHtml::tag("input", array("type"=>"hidden","value"=>($data->lineasAccions)?$data->lineasAccions[0]->productoEstrategico->id:$data->productoEspecifico->subproducto->productoEstrategico->id))."$ ".number_format(
                            ProductosItemes::Model()->findBySql(($data->lineasAccions)?"
                                                 SELECT  SUM(t.monto*(pecc.porcentaje/100)) AS monto
                                                 FROM  productos_itemes t
                                                 JOIN producto_estrategico_centro_costo pecc on pecc.centro_costo_id=t.centro_costo_id AND pecc.producto_estrategico_id =".$data->lineasAccions[0]->productoEstrategico->id."                                                   
                                                 WHERE t.planificacion_id='.$idPlanificacion.'":"
                                                 SELECT  SUM(t.monto*(pecc.porcentaje/100)) AS monto
                                                 FROM  productos_itemes t
                                                 JOIN producto_estrategico_centro_costo pecc on pecc.centro_costo_id=t.centro_costo_id AND pecc.producto_estrategico_id =".$data->productoEspecifico->subproducto->productoEstrategico->id."                                                   
                                                 WHERE t.planificacion_id='.$idPlanificacion.'")->monto,0, "", ".")',           
        ),
         'nombre', 
        array(          
         'header'=>'Presupuesto Actividades (PA)',
         'value'=>'"$ ".number_format(ProductosItemes::Model()->findBySql("SELECT SUM(ia.monto) as monto
                                                            FROM itemes_actividades ia
                                                            INNER JOIN actividades ac ON  ia.actividad_id = ac.id
                                                            INNER JOIN indicadores ind ON ac.indicador_id = ind.id
                                                 WHERE ind.id = ".$data->id."")->monto,0, "", ".")',           
        ),        
        /*array(            
            'name'=>'columnHiden',
            'header'=>'Producto Estrátegico',
            'type'=>'number',
            //if es necesario cambiar la imagen debe devolver un 1(solo lectura)... de lo contrario un 0(puede editar) 
            'value'=>'(ActividadesController::validateAccessbyIndicador($data->id))?0:1',
            //'value'=>'',
            
            'headerHtmlOptions'=>array('style'=>'display:none;', 'class'=>'changeImage'),
            'htmlOptions'=>array('style'=>'display:none;', 'class'=>'changeImage'),  
           // 'header'=>false,
           // 'filter'=>false,
        ), */                       
        array(
            'class' => 'CButtonColumn',
          //  'template'=>''.(ActividadesController::validateAccess())?"{update}":"{ver}",
            'template'=>'{view}{update}',
            'header' => 'Acción',
            'buttons'=>array(                  
                'update'=>
                    array(
                            'url'=>'$this->grid->controller->createUrl("view", array("id"=>$data->primaryKey))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                            'label'=>'',
                            'visible'=>'Yii::app()->user->checkAccessChange(array("modelName"=>"Indicadores","fieldName"=>"responsable_id","idRow"=>$data->id))',
                        ),
                'view'=>
                        array(    
                            'url'=>'$this->grid->controller->createUrl("ver", array("id"=>$data->id))',                            
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                            'visible'=>'Yii::app()->user->checkAccessChangeDataGore("IndicadoresController",array(),"view")',
                        ),
                            
            ),   
        ),
        array(    
         'name'=>'sum_presupuesto_funcionamiento',        
         'header'=>'Presupuesto de Funcionamiento (PO + PA)',
         'type'=>'raw',
         'value'=>'CHtml::tag("input", array("type"=>"hidden","value"=>($data->lineasAccions)?$data->lineasAccions[0]->productoEstrategico->id:$data->productoEspecifico->subproducto->productoEstrategico->id))."$ ".number_format(
         
                ProductosItemes::Model()->findBySql(
                                    ($data->lineasAccions)?
                                    "SELECT SUM(a.monto) as monto FROM(
                                                 SELECT  SUM(t.monto*(pecc.porcentaje/100)) AS monto,1
                                                 FROM  productos_itemes t
                                                 JOIN producto_estrategico_centro_costo pecc on pecc.centro_costo_id=t.centro_costo_id AND pecc.producto_estrategico_id = ".$data->lineasAccions[0]->productoEstrategico->id."
                                                 WHERE t.planificacion_id='.$idPlanificacion.'
                                                 UNION ALL
                                                 SELECT SUM(itact.monto) as monto,Pesp.id
                                                        FROM subproductos subp
                                                        INNER JOIN productos_estrategicos Pesp ON subp.producto_estrategico_id = Pesp.id
                                                        INNER JOIN productos_especificos proespeci ON subp.id = proespeci.subproducto_id
                                                        INNER JOIN indicadores ind ON proespeci.id = ind.producto_especifico_id
                                                        INNER JOIN actividades act ON ind.id = act.indicador_id
                                                        INNER JOIN itemes_actividades itact ON act.id = itact.actividad_id
                                                        where Pesp.id =".$data->lineasAccions[0]->productoEstrategico->id."
                                                        group by Pesp.id) a                                                 
                                                 "
                                   :
                                    "SELECT SUM(a.monto) as monto FROM(
                                                 SELECT  SUM(t.monto*(pecc.porcentaje/100)) AS monto,1
                                                 FROM  productos_itemes t
                                                 JOIN producto_estrategico_centro_costo pecc on pecc.centro_costo_id=t.centro_costo_id AND pecc.producto_estrategico_id = ".$data->productoEspecifico->subproducto->productoEstrategico->id."
                                                 WHERE t.planificacion_id='.$idPlanificacion.'
                                                 UNION ALL
                                                 SELECT SUM(itact.monto) as monto,Pesp.id
                                                        FROM subproductos subp
                                                        INNER JOIN productos_estrategicos Pesp ON subp.producto_estrategico_id = Pesp.id
                                                        INNER JOIN productos_especificos proespeci ON subp.id = proespeci.subproducto_id
                                                        INNER JOIN indicadores ind ON proespeci.id = ind.producto_especifico_id
                                                        INNER JOIN actividades act ON ind.id = act.indicador_id
                                                        INNER JOIN itemes_actividades itact ON act.id = itact.actividad_id
                                                        where Pesp.id =".$data->productoEspecifico->subproducto->productoEstrategico->id."
                                                        group by Pesp.id) a                                                 
                                                 "              
                                                 )->monto,0, "", ".")',   
                                                         
        ),  
      ),
    ));
?>

