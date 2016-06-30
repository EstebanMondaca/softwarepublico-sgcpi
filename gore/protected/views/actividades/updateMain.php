<?php

$this->breadcrumbs = array(
    //$model->label(2) => array('index'),
    //GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
    Yii::t('app', 'Update'),
);

?>

<div class="form">
    <h3>Actualizar Actividades de un indicador</h3>
    <div id="content">
        <ul id="yw1" class="MenuOperations">
            <li><a href="<?php echo Yii::app()->request->baseUrl."/actividades/create?idIndicador=".$_GET['id'] ?>" class="cboxElement" onclick="actualizarSRCIframe(this);return false;">Crear</a></li>
        </ul>
    </div>    
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'actividades-grid',
    'dataProvider' => $modelActividades->search(),
    //'afterAjaxUpdate'=>'parent.actualizarCierreModal()',
    'columns' => array(
        //'id',
        array(
        'header'=>'N°',
        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        'nombre',
        'fecha_inicio',
        'fecha_termino',
        array(
                'name'=>'actividad_parent',
                'value'=>'GxHtml::valueEx($data->actividad)',
        ),
        array(          
         'header'=>'Monto total',
         'value'=>'"$ ".number_format(ProductosItemes::Model()->findBySql("SELECT SUM(ia.monto) as monto
                                                            FROM itemes_actividades ia
                                                        WHERE   ia.actividad_id = ".$data->id."")->monto,0, "", ".")', 
        ),array(
                        'class' => 'CButtonColumn',
                        'header' => 'Acción',
                        'afterDelete'=>'function(link,success,data){ if(success) parent.mostrarMensajes(data); }',
                        'template'=>'{update}{delete}',
                            'buttons'=>array(
                                'update'=>
                                    array(
                                            'url'=>'$this->grid->controller->createUrl("/actividades/update/", array("id"=>$data->primaryKey,"idIndicador"=>'.$_GET['id'].'))',
                                            'options'=>array(                                                
                                               'class'=>'formIframe',
                                               'onclick'=>'actualizarSRCIframe(this);return false;',                                                                                                                                       
                                            ),
                                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                                        ),
                                  'delete'=>
                                    array(
                                            'url'=>'$this->grid->controller->createUrl("/actividades/delete/", array("id"=>$data->primaryKey))',
                                            
                                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
                                        ),
                               )
                    ),
    ),
));
?>
</div>

<div id="iframeModal" style="display:none;height: 461px;">
                <iframe width="100%" height="100%" frameborder="0" scrolling="no">
                    
                </iframe>
</div>