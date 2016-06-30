     <div class="form">
        <h3>Actividades de un indicador</h3>
<?php

if(!$modelActividades){
    echo '<span class="empty">No se encontraron resultados.</span>';
}

foreach($modelActividades as $model){

?>        
        <?php         
         $this->widget('ext.widgets.DetailView4Col', array(
        'data'=>$model,
        'attributes'=>array(
                array(
                    'header'=>$model->nombre,
                ),
                'fecha_inicio',
        'fecha_termino',
        array(
            'name'=>'descripcion',
            'oneRow'=>true,
        ),
        array(
            'name'=>'actividad_parent',
            'value'=>$model->actividad,
        ),
        array(
                    'name' => 'indicador',
                    'type' => 'raw',
                    'value' => $model->indicador,
                    )
        ,array(
            'label'=>'Presupuesto Actividad',
            'type'=>'raw',
            'value'=>$model->relatedItemesActividades,
            'oneRow'=>true,
        ),   
        )
        )); //getRelatedItemesActividades
         
 } ?>   
</div>