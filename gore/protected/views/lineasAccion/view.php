<?php
Yii::app()->clientScript->registerScript('ready', "

    $('.labelpuntaje_elemento').each(function(){
         var total=(parseFloat($(this).parent('td').parent('tr').children('.puntaje_esperado').html()) - parseFloat($(this).parent('td').parent('tr').children('.puntaje_actual').html()))*parseFloat($(this).prev('input.puntaje_elemento').val());
         total=Math.round(total*100)/100;//con 2 decimales                 
         if(isNaN(parseFloat(total))){
             $(this).html('0');
         }else{
             $(this).html(total);
         }
         
    });          
   
",3);
$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	'LA/AMI',
);

?>

<h1>Línea de acción y AMI</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
array(
			'name' => 'idTipoLa',
			'type' => 'raw',
			'value' => $model->idTipoLa,
			),
'nombre',
'descripcion')
)); ?>
<br/><br/><div class="fieldset2 grid-view">
        <div class="legend">Asignación Responsabilidad Interna</div>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
array(
            'name' => 'productoEstrategico',
        
            'value' => $model->productoEstrategico,
            ),
array(
            'name' => 'centroCosto',
            
            'value' => $model->centroCosto,
            ),
array(
        'name' => 'idResponsableImplementacion',            
        'value' => $model->idResponsableImplementacion->nombrecompleto,
        ),
array(
            'name' => 'idResponsableMantencion',
        
            'value' => $model->idResponsableMantencion->nombrecompleto,
            ),

    ),
)); 
        
        echo '<br/><br/><h3>'.GxHtml::encode($model->getRelationLabel('users')).'</h3>';
    	echo GxHtml::openTag('ul');    
    	foreach($model->users as $k=>$v) {
    		echo GxHtml::openTag('li');
    		echo GxHtml::encode($model->users[$k]->nombrecompleto);
    		echo GxHtml::closeTag('li');
    	}
    	echo GxHtml::closeTag('ul');
        if(!$model->users){
            echo '<span class="empty">No se encontraron resultados.</span>';
        }
	
?>
</div>

<div class="fieldset2 grid-view">
        <div class="legend">Información de Cumplimiento</div>
<?php
     $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(            
            array(
                'label'=>'Indicador',
                'name' => 'idIndicador', 
                'type' => 'raw',    
                'value' => $model->idIndicador !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->idIndicador)), array('indicadores/view', 'id' => GxActiveRecord::extractPkValue($model->idIndicador, true)),array('class'=>'update')) : null, 
            ),
            array(
                'label'=>'Indicador de Cumplimiento',
                'name' => 'descripcion',    
                'value' => $model->idIndicador->descripcion,
            ),
            array(
                'label'=>'Medio de Verificación',
                //'name' => 'medio_verificacion',    
                'value' => ($model->idIndicador->medio_verificacion)?$model->idIndicador->medio_verificacion:null,
            ),
            array(
                'label'=>'Meta Anual',
               // 'name' => 'meta_anual',    
                'value' => $model->idIndicador->meta_anual,
            ),
            array(
                'label'=>'Frecuencia de Control',
              //  'name' => 'frecuenciaControl',    
                'value' => $model->idIndicador->frecuenciaControl,
            ),
        )
    ));
?>
</div>



<div class="fieldset2 grid-view">
        <div class="legend">Elementos de Gestión Asociados</div> 
<?php
	$this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'la-elem-gestion-grid',
                'dataProvider' => $modelLA->searchLineasAccion(), 
                'enableSorting'=>false,
                'summaryText'=>'',                    
                'enablePagination'=>false,                                               
                'columns' => array(                         
                    array(
                            'header'=>'Elementos de Gestión',
                            'name'=>'id_elem_gestion',
                            'value'=>'$data->idElemGestion->n_elementogestion',
                            'htmlOptions'=>array('width'=>'90'),
                    ),                
                    array(
                            'header'=>'Nombre elementos de gestión',
                            'name'=>'nombre',
                            'value'=>'$data->idElemGestion->nombre',
                         ),
                    array(
                            'header'=>'Puntaje Actual',
                            'name'=>'puntaje_actual',
                            'value'=>'$data->idElemGestion->ultimoPuntajeActual',
                            'htmlOptions'=>array('width'=>'90','class'=>'puntaje_actual'),
                         ),
                    array(
                            'header'=>'Puntaje Esperado',
                            'name'=>'puntaje_esperado',           
                            'value'=>'$data->puntaje_esperado',
                            'htmlOptions'=>array('width'=>'90','class'=>'puntaje_esperado'),
                         ),
                    array(
                            'type'=>'raw',
                            'value'=>'CHtml::hiddenField("LaElemGestion[$row][id_elem_gestion]",$data->id_elem_gestion)',
                            'htmlOptions'=>array('style'=>'width:0%; display:none','class'=>'id_elem_gestion'),
                            'headerHtmlOptions'=>array('style'=>'width:0%; display:none')
                    ),
                    array(
                            'type'=>'raw',
                            'header'=>'Diferencia Ponderada',
                             'value'=>'CHtml::hiddenField("puntaje_elemento",$data->idElemGestion->idSubcriterio->puntaje_elemento,array("class"=>"puntaje_elemento"))." ".CHtml::label("","puntaje_elemento",array("class"=>"labelpuntaje_elemento"))',
                            'htmlOptions'=>array('width'=>'90'),
                         ),
                    array(
                            'type'=>'raw',
                            'value'=>'CHtml::hiddenField("LaElemGestion[$row][id]",$data->id)',
                            'htmlOptions'=>array('style'=>'width:0%; display:none','class'=>'id_la_elem_gestion'),
                            'headerHtmlOptions'=>array('style'=>'width:0%; display:none')
                    )
                ),
            ));
?>
</div>