
<?php
$this->renderPartial('_form', array(
		'model' => $model,
        'titulo'=>Yii::t('app', 'Update') . ' ' . GxHtml::encode($model->label())));
?>