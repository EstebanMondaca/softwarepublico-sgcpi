<?php
/* @var $this DesafiosEstrategicosController */
/* @var $model DesafiosEstrategicos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php 
Yii::app()->clientScript->registerScript('disenio', "
    $(document).ready(function() {
        $('table tr').removeClass();
        $('table tr:even').addClass('even');
        $('table tr:odd').addClass('odd');
        $('.numeroFila').each(function(i){
           $(this).html(i+1); 
        });
        cambiarEstadoInputSegunCheckbox();
    });
");

$form=$this->beginWidget('CActiveForm', array(
    'id'=>'desafios-estrategicos-form',
    'enableAjaxValidation'=>false,
)); ?>

    <?php 
        if(isset($titulo)) echo "<h3>".$titulo."</h3>";
        
        echo '<strong>Desafío Estratégico: </strong>'.$model->nombre;
        echo '<br/><strong>Perspectivas Estrátegicas del BSC: </strong>'.$model->perspectivaEstrategica;
        
    ?>
    

    <?php echo $form->errorSummary($model); ?>
       
    <div class="grid-view"> 
        <table class="items">
            <thead>
              <tr><th width="15">N°</th><th>Desafío Estratégico</th><th width="50px">Vínculo</th></tr>
            </thead>
            <tbody>
                <?php  
                    $consulta=DesafiosEstrategicos::model()->findAll(array('order'=>'t.nombre','select'=>'t.*,dd.*','distinct'=>'true','condition'=>'t.id!='.$model->id.' AND p.periodo_proceso_id = '.Yii::app()->session['idPeriodo'].' AND t.estado = 1','join'=>'INNER JOIN planificaciones p ON t.planificacion_id=p.id LEFT JOIN desafio_desafio dd on t.id=dd.desafio_estrategico_mm_id AND desafio_estrategico_id='.$model->id));
                    $consultaSeleccionados=DesafiosEstrategicos::model()->findAllBySql('select t.* from desafios_estrategicos t
                                                    INNER JOIN planificaciones p ON t.planificacion_id=p.id                                                     
                                                    INNER JOIN desafio_desafio dd on t.id=dd.desafio_estrategico_mm_id AND desafio_estrategico_id='.$model->id.'                                                    
                                                    WHERE t.estado=1 AND p.periodo_proceso_id ='.Yii::app()->session['idPeriodo'].'
                                                    ORDER BY t.nombre');
                   $x=0;
                   $seleccionadosArray=array();
                   foreach($consultaSeleccionados as $v){
                       $seleccionadosArray[$v->id]=$v->id;
                   }
                    
                   foreach($consulta as $v){
                        if (array_key_exists($v->id, $seleccionadosArray)) {
                            echo '<tr class="odd"><td class="numeroFila"></td><td>'.$v->nombre.'</td><td align="center"><input checked="checked" type="checkbox" name="DesafiosEstrategicos[desafioDesafios][]" value="'.$v->id.'" id="DesafiosEstrategicos_desafioDesafios_'.$x.'"></td></tr>';
                        }else{
                            echo '<tr class="odd"><td class="numeroFila"></td><td>'.$v->nombre.'</td><td align="center"><input type="checkbox" name="DesafiosEstrategicos[desafioDesafios][]" value="'.$v->id.'" id="DesafiosEstrategicos_desafioDesafios_'.$x.'"></td></tr>';
                        }
                        $x++;
                   }
                ?>
            </tbody>
        </table>
     </div>    

    
    <div class="limpia"></div>
    <div class="row buttons">        
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->