<?php

$this->breadcrumbs = array(
	//$model->label(2) => array('index'),
);

?>

<h1><?php echo Yii::t('app', 'Seleccionar') . ' Periodo'; ?></h1>


<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'periodos-procesos-form',
	'enableAjaxValidation' => true,
));
		echo $form->errorSummary($model); 
?>

		<?php 
		echo "<label>Periodo</label>";
		print_r ($model);
		echo $form->dropDownList($model, 'planificaciones', GxHtml::encodeEx(GxHtml::listDataEx(PeriodosProcesos::model()->findAllAttributes(null,true)), false, true));
		 //print_r (GxHtml::encodeEx(GxHtml::listDataEx(PeriodosProcesos::model()->findAllAttributes(null, true)))); 
		
			$this->endWidget();
		
			?>
</div><!-- form -->

