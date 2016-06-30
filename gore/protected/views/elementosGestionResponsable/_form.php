<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'elementos-gestion-responsable-form',
	'enableAjaxValidation' => false,
));
?>

	<?php 
        if(isset($titulo)) echo "<h3>".$titulo."</h3>";
    ?>
    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

	<?php echo $form->errorSummary($model); ?>
    <table border="0" cellspacing="5" cellpadding="5" width="100%">
        <tr>
            <td><?php echo $form->labelEx($model,'elemento_gestion_id'); ?></td>
            <td><?php
                    if(isset($model->elementoGestion)){
                        echo $model->elementoGestion;
                    }else{
                        if(isset($_GET['id'])){
                            $elementoGestion=ElementosGestion::model()->findByPk($_GET['id']);
                            if(isset($elementoGestion)) echo $elementoGestion->nombre; 
                        }
                        
                    }                    
                     
             ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model,'responsable_id'); ?></td>
            <td>
                <?php 
                    echo $form->dropDownList($model, 'responsable_id', GxHtml::listDataEx(User::model()->findAll(array('order'=>'ape_paterno ASC','condition'=>'status=1 AND estado=1')),'id','nombrecompleto'),array(
                    'ajax' => array(
                        'beforeSend'=>'function() {$("#ElementosGestionResponsable_centro_costo_id").empty().append("<option>Cargando...</option>"); }',
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('CentrosCostos/centroCostoPorUsuario'), 
                        'update'=>'#ElementosGestionResponsable_centro_costo_id', 
                    ))); 
                    
                    ?>
                <?php echo $form->error($model,'responsable_id'); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model,'centro_costo_id'); ?></td>
            <td>
                <?php 
                    if(isset($model->responsable_id))
                        echo $form->dropDownList($model, 'centro_costo_id', GxHtml::listDataEx(CentrosCostos::model()->with('users')->findAll(array('condition'=>'t.estado=1 AND user.id='.$model->responsable_id)))); 
                    else {
                        echo $form->dropDownList($model, 'centro_costo_id', GxHtml::listDataEx(CentrosCostos::model()->findAll(array('condition'=>'estado=1'))));
                    }
                    ?>
                <?php echo $form->error($model,'centro_costo_id'); ?>
            </td>
        </tr>
    </table>    
        <?php 
        
            if(isset($model->elemento_gestion_id))
                echo $form->hiddenField($model, 'elemento_gestion_id'); 
             else
                 echo $form->hiddenField($model, 'elemento_gestion_id',array('value'=>''.$_GET['id'])); 
             
             if(isset($model->planificacion_id))
                echo $form->hiddenField($model, 'planificacion_id'); 
             else
                 echo $form->hiddenField($model, 'planificacion_id',array('value'=>''.Yii::app()->session['idPlanificaciones']));
        ?>
<div class="row buttons">        
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?>
    </div> 
    <?php 
$this->endWidget();
?>
</div><!-- form -->