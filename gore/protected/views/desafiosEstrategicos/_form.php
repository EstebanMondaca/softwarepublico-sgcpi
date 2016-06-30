<?php
/* @var $this DesafiosEstrategicosController */
/* @var $model DesafiosEstrategicos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'desafios-estrategicos-form',
    'enableAjaxValidation'=>false,
)); ?>

    <?php 
        if(isset($titulo)) echo "<h3>".$titulo."</h3>";
    ?>
    <p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>
    

    <div class="rowleft72">
        <?php echo $form->labelEx($model,'nombre'); ?>
        <?php echo $form->textField($model,'nombre',array('style'=>'width: 510px;','maxlength'=>200,'class'=>'caja-texto')); ?>
        <?php echo $form->error($model,'nombre'); ?>
    </div>
    <div class="rowright23">
        <?php echo $form->labelEx($model,'perspectiva_estrategica_id',array('class'=>'blockLabel')); ?>
        <?php echo $form->radioButtonList($model,'perspectiva_estrategica_id',GxHtml::encodeEx(GxHtml::listDataEx(PerspectivasEstrategicas::model()->findAllByAttributes(array('estado'=>'1'))), false, true), array('class'=>'formCheckbox')); ?>
        <?php echo $form->error($model,'perspectiva_estrategica_id'); ?>
    </div>
    <div class="rowleft72">
        <?php echo $form->labelEx($model,'descripcion',array('class'=>'blockLabel')); ?>
        <?php echo $form->textArea($model,'descripcion',array('rows'=>3,'class'=>'caja-texto','style'=>'width:632px;')); ?>
        <?php /*$this->widget(
        'application.extensions.redactorjs.Redactor', array( 
            'editorOptions' => array( 
                'imageUpload' => Yii::app()->createAbsoluteUrl('roundtrip/upload'),
                'imageGetJson' => Yii::app()->createAbsoluteUrl('roundtrip/listimages'),
                'height'=>200
            ),
            'model' => $model, 
            'attribute' => 'descripcion'));
         */         
        ?>        
        <?php echo $form->error($model,'descripcion'); ?>
        <br/>
        <?php if($model->planificacion_id)
                echo $form->hiddenField($model, 'planificacion_id'); 
             else{
                 $value='';
                 if(isset(Yii::app()->session['idPeriodo'])){
                    $value=Planificaciones::model()->findAll(array('select'=>'t.id','condition'=>'p.id='.Yii::app()->session['idPeriodo'].' AND estado=1','join'=>'inner join periodos_procesos p on p.id=t.periodo_proceso_id'));
                    if(isset($value[0]->id))
                        $value=$value[0]->id;
                 }
                 
                 echo $form->hiddenField($model, 'planificacion_id',array('value'=>''.$value));
             }
                  
        ?>
    </div>

    
    <div class="limpia"></div>
    <div class="row buttons">        
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->