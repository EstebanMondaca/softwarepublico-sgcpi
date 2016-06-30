
<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create',
        'titulo'=>Yii::t('app', 'Create') . ' ' . GxHtml::encode($model->label())));
?>