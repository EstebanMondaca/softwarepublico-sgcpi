<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'id_indicador'); ?>
		<?php echo $form->dropDownList($model, 'id_indicador', GxHtml::listDataEx(Indicadores::model()->findAll(array('condition'=>'estado=1'))), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'id_instrumento'); ?>
		<?php echo $form->dropDownList($model, 'id_instrumento', GxHtml::listDataEx(Instrumentos::model()->findAll(array('condition'=>'estado=1'))), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'ponderacion'); ?>
		<?php echo $form->textField($model, 'ponderacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'estado'); ?>
		<?php echo $form->textField($model, 'estado'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
