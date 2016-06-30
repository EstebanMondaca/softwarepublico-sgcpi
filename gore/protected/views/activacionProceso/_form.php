<?php 
Yii::app()->clientScript->registerScript('disenio', "
    $(document).ready(function() {
        $('.datepicker').datepicker({'dateFormat':'yy-mm-dd','monthNames':['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],'monthNamesShort':['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],'dayNames':['Domingo,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado'],'dayNamesMin':['Do','Lu','Ma','Mi','Ju','Vi','Sa']});
    });
");

?>

<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'activacion-proceso-form',
	'enableAjaxValidation' => true,
));
?>
	<h3><?php echo Yii::t('app', 'Update') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h3>
	
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'periodo_id'); ?>: <b> 
		<?php 
			//echo $form->dropDownList($model, 'periodo_id', GxHtml::listDataEx(PeriodosProcesos::model()->findAllAttributes(null, true))); 
			echo $model->periodo;
		?>
		</b>
		<?php echo $form->error($model,'periodo_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'nombre_contenedor'); ?>: <b> 
		<?php 
			//echo $form->textField($model, 'nombre_contenedor', array('maxlength' => 255)); 
			 echo $model->nombre_contenedor;	
		?>
		</b>
		<?php echo $form->error($model,'nombre_contenedor'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'inicio'); ?>
		<?php //echo $form->textField($model, 'inicio', array('class'=>'datepicker')); ?>
		<?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                //'name'=>'date',
                'model'=>$model,
                'attribute'=>'inicio',
                'language'=>Yii::app()->language=='es' ? 'es' : null,
                'options'=>array(
                    'changeMonth'=>'true', 
                    'changeYear'=>'true',   
                    'yearRange' => '-99:+2',        
                    'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                    'showOn'=>'button', // 'focus', 'button', 'both'
                    'dateFormat'=>'yy-mm-dd 00:00:00', //'dd/mm/yy',
                    'value'=>date('yy-mm-dd 00:00:00'),
                    'theme'=>'redmond',
                    'buttonText'=>Yii::t('ui','Selecionar Calendario'), 
                    'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png', 
                    'buttonImageOnly'=>true,
                ),
                'htmlOptions'=>array(
                    'style'=>'vertical-align:top;width: 155px;',
                    'class'=>'span2',
                ),  
            ));
            
            ?>
            
		<?php echo $form->error($model,'inicio'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'fin'); ?>
		<?php //echo $form->textField($model, 'fin'); ?>
				<?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                //'name'=>'date',
                'model'=>$model,
                'attribute'=>'fin',
                'language'=>Yii::app()->language=='es' ? 'es' : null,
                'options'=>array(
                    'changeMonth'=>'true', 
                    'changeYear'=>'true',   
                    'yearRange' => '-99:+2',        
                    'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                    'showOn'=>'button', // 'focus', 'button', 'both'
                    'dateFormat'=>'yy-mm-dd 00:00:00', //'dd/mm/yy',
                    'value'=>date('yy-mm-dd 00:00:00'),
                    'theme'=>'redmond',
                    'buttonText'=>Yii::t('ui','Selecionar Calendario'), 
                    'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png', 
                    'buttonImageOnly'=>true,
                ),
                'htmlOptions'=>array(
                    'style'=>'vertical-align:top;width: 155px;',
                    'class'=>'span2',
                ),  
            ));
            
            ?>
            
		<?php echo $form->error($model,'fin'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
<div class="limpia"></div>
</div><!-- form -->