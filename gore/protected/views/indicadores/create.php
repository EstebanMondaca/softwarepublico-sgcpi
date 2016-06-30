<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Create'),
);

?>

<?php
$tipoProducto = TiposProductos::model()->find(array('condition'=>'id='. $nombreProductoEstrategico->tipo_producto_id .' AND estado = 1'));

  
$this->renderPartial('_form', array(
		'model' => $model,
		'producto_especificoID' => $producto_especificoID,
		'producto_especificoN' => $producto_especificoN,
		'centroCosto' => $centroCosto,
		'centroResponsabilidad'=> $centroResponsabilidad,
		'usuarioActivoConcatenado'=>$usuarioActivoConcatenado,
		'buttons' => 'create',
		'nombreProductoEstrategico' => $nombreProductoEstrategico ,
		'nombreSubproducto' => $nombreSubproducto,
		'titulo' => Yii::t('app', 'Create') . ' INDICADOR DE DESEMPEÑO ASOCIADO A UN '.$tipoProducto->descripcion . GxHtml::encode(GxHtml::valueEx($model))
		)
);

?>