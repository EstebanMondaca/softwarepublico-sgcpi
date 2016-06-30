<div class="subForm">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'productos-especificos-form',
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


		<?php if($model->subproducto_id)
                echo $form->hiddenField($model, 'subproducto_id'); 
             else
                echo $form->hiddenField($model, 'subproducto_id',array('value'=>''.$_GET['subProducto'])); 
        ?>
		<div class="row">
    		<?php echo $form->labelEx($model,'nombre'); ?>
    		<?php echo $form->textField($model, 'nombre', array('style'=>'width: 800px;','maxlength' => 200)); ?>
    		<?php echo $form->error($model,'nombre'); ?>
		</div><!-- row -->
		<div class="row">
    		<?php echo $form->labelEx($model,'descripcion',array('class'=>'blockLabel')); ?>
    		<?php echo $form->textArea($model, 'descripcion',array('rows'=>2, 'style'=>'width: 858px;')); ?>
    		<?php echo $form->error($model,'descripcion'); ?>
		</div><!-- row -->
		

<div class="row buttons">        
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar',array('style'=>'background:url("'.Yii::app()->request->baseUrl.'/css/imag/bt1_verde.png") no-repeat scroll 0 0 transparent;')); ?>
        <?php echo CHtml::button('Cancelar',array('onclick'=>"parent.cerrarModalSinCambios();",'style'=>'background:url("'.Yii::app()->request->baseUrl.'/css/imag/bt1_verde.png") no-repeat scroll 0 0 transparent;')); ?>        
    </div>
<?php
$this->endWidget();
?>

</div><!-- form -->