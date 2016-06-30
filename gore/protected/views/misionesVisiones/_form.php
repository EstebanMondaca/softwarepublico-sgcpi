<?php
/* @var $this MisionesVisionesController */
/* @var $model MisionesVisiones */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'misiones-visiones-form',
	'enableAjaxValidation'=>false,
)); ?>
    <?php 
        if(isset($titulo)) echo "<h3>".$titulo."</h3>";
    ?>
	<p class="note">
	   <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>
	</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php //echo $form->textArea($model,'descripcion',array('rows'=>6, 'cols'=>50)); 
		$this->widget(
        'application.extensions.redactorjs.Redactor', array( 
        'toolbar' => 'mini',
            'editorOptions' => array( 
                  
                //'imageUpload' => Yii::app()->createAbsoluteUrl('roundtrip/upload'),
               // 'imageGetJson' => Yii::app()->createAbsoluteUrl('roundtrip/listimages'),
                'height'=>200
            ),
            'model' => $model, 
            'attribute' => 'descripcion'));          
		?>
		
		<?php echo $form->error($model,'descripcion'); ?>
	</div>
    <?php if($model->planificacion_id)
                echo $form->hiddenField($model, 'planificacion_id'); 
             else{
                 $value='';
                 if(isset(Yii::app()->session['idPeriodo'])){
                    $value=Planificaciones::model()->findAll(array('select'=>'t.id','condition'=>'p.id='.Yii::app()->session['idPeriodo'].'','join'=>'inner join periodos_procesos p on p.id=t.periodo_proceso_id'));
                    if(isset($value[0]->id))
                        $value=$value[0]->id;
                 }
                 
                 echo $form->hiddenField($model, 'planificacion_id',array('value'=>''.$value));
             }
                  
        ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->